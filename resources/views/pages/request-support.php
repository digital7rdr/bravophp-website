<?php
/** @var array $pg @var array $request */
ob_start();
comp_request_panel($request);
$panel = ob_get_clean();
comp_hero($pg['hero'], 'compact', $panel);

comp_section_open(null, null, 'tint');
echo '<div class="grid gap-5 sm:grid-cols-3">';
foreach ($pg['assurance']['cards'] as $c) comp_feature_card($c);
echo '</div>';
comp_section_close();

comp_section_open($pg['steps']['heading']);
comp_steps($pg['steps']['items']);
comp_section_close();

comp_section_open($pg['related']['heading'], null, 'tint');
echo '<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">';
foreach ($pg['related']['cards'] as $c) comp_service_card($c);
echo '</div>';
comp_section_close();

comp_cta($pg['cta']);
