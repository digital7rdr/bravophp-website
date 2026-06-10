<?php
/** @var array $pg @var array $request */
ob_start();
comp_request_panel($request);
$panel = ob_get_clean();
comp_hero($pg['hero'], 'compact', $panel);

comp_section_open($pg['process']['heading'], null, 'tint');
comp_steps($pg['process']['steps']);
comp_section_close();

comp_section_open($pg['services']['heading'], $pg['services']['intro'] ?? null);
echo '<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">';
foreach ($pg['services']['cards'] as $c) comp_service_card($c);
echo '</div>';
comp_section_close();

comp_cta($pg['cta']);
