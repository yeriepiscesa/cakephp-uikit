import '../image-preview.js';
import 'quill/dist/quill.snow.css';

import Quill from 'quill';

function initWysiwyg() {
    const editorEl = document.querySelector('#editor');
    if (!editorEl) {
        return;
    }

    const textarea = document.querySelector('textarea[name="content"]');

    const quill = new Quill(editorEl, {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ header: 1 }, { header: 2 }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ script: 'sub' }, { script: 'super' }],
                [{ indent: '-1' }, { indent: '+1' }],
                [{ direction: 'rtl' }],
                [{ size: ['small', false, 'large', 'huge'] }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
                ['clean'],
            ],
        },
    });

    if (textarea && textarea.value) {
        quill.clipboard.dangerouslyPasteHTML(textarea.value);
    }

    const syncTextarea = () => {
        if (textarea) {
            textarea.value = quill.root.innerHTML;
        }
    };

    quill.on('text-change', syncTextarea);
    textarea?.form?.addEventListener('submit', syncTextarea);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWysiwyg);
} else {
    initWysiwyg();
}

Alpine.start();
