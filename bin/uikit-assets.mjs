#!/usr/bin/env node
import { cpSync, existsSync, mkdirSync, readFileSync, rmSync } from 'node:fs';
import path from 'node:path';
import { spawnSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';

const pluginRoot = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const hostRoot = path.resolve(process.cwd());
const command = process.argv[2];

function relativeDirectory(value, prefix) {
    if (typeof value !== 'string' || !value.startsWith(prefix + '/') ||
        value.split('/').some((part) => !part || part === '.' || part === '..') ||
        path.isAbsolute(value) || value.includes('\\')) {
        throw new Error(`Expected a project-relative directory inside ${prefix}/, got ${JSON.stringify(value)}`);
    }

    return value;
}

function config() {
    const defaultConfig = JSON.parse(readFileSync(path.join(pluginRoot, 'config/uikit_assets.json'), 'utf8'));
    const hostConfig = path.join(hostRoot, 'config/uikit_assets.json');
    const settings = existsSync(hostConfig)
        ? { ...defaultConfig, ...JSON.parse(readFileSync(hostConfig, 'utf8')) }
        : defaultConfig;
    relativeDirectory(settings.workDirectory, 'resources');
    relativeDirectory(settings.buildDirectory, 'webroot');
    new URL(settings.devServerUrl);

    return settings;
}

function prepare(settings) {
    const workDir = path.join(hostRoot, settings.workDirectory);
    mkdirSync(workDir, { recursive: true });
    for (const file of ['package.json', 'package-lock.json', 'vite.config.js']) {
        cpSync(path.join(pluginRoot, file), path.join(workDir, file));
    }
    // Vite resolves imports from the entry location. Staging sources alongside
    // node_modules keeps dependencies out of the Composer package.
    rmSync(path.join(workDir, 'resources'), { recursive: true, force: true });
    cpSync(path.join(pluginRoot, 'resources'), path.join(workDir, 'resources'), { recursive: true });

    return workDir;
}

function runNpm(args, workDir, settings) {
    const result = spawnSync(process.platform === 'win32' ? 'npm.cmd' : 'npm', args, {
        cwd: workDir,
        stdio: 'inherit',
        env: { ...process.env, UIKIT_HOST_ROOT: hostRoot, UIKIT_OUTPUT_DIR: settings.buildDirectory,
            UIKIT_DEV_SERVER_URL: settings.devServerUrl },
    });
    if (result.error) {
        throw result.error;
    }
    process.exitCode = result.status ?? 1;
}

try {
    if (!['prepare', 'install', 'build', 'dev'].includes(command)) {
        throw new Error('Usage: node vendor/yeriepiscesa/cakephp-uikit/bin/uikit-assets.mjs prepare|install|build|dev (run from the CakePHP project root)');
    }
    if (!existsSync(path.join(hostRoot, 'config/paths.php'))) {
        throw new Error('Run this command from the CakePHP project root.');
    }
    const settings = config();
    const workDir = prepare(settings);
    if (command === 'install') {
        runNpm(['ci'], workDir, settings);
    } else if (command === 'build' || command === 'dev') {
        if (!existsSync(path.join(workDir, 'node_modules'))) {
            throw new Error('Run the install command first to populate ' + path.join(workDir, 'node_modules'));
        }
        runNpm(['run', command], workDir, settings);
    }
} catch (error) {
    console.error(error.message);
    process.exitCode = 1;
}
