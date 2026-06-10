<?php
/** @var array $pg */
comp_hero($pg['hero'], 'compact');

comp_section_open($pg['approach']['heading'], $pg['approach']['intro'] ?? null, 'tint', 'approach');
echo '<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">';
foreach ($pg['approach']['cards'] as $c) comp_feature_card($c);
echo '</div>';
comp_section_close();

comp_cta($pg['cta']);
