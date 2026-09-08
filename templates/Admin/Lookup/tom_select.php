<?php
/**
 * Lookup results for Tom Select
 *
 * @var Cake\Datasource\Paging\PaginatedResultSet $lookupResults
 * @var string $viewVar
 */
$this->response = $this->response->withType('application/json');

$more = $lookupResults->hasNextPage();
$out = [
	'results' => $lookupResults->toArray(),
	'pagination' => ['more' => (bool)$more],
];

echo json_encode($out, JSON_UNESCAPED_UNICODE);
return;