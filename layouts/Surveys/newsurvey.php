<?php

defined('_EXEC') or die;

$this->dependencies->add(['js', '{$path.js}Surveys/newsurvey.js']);
$this->dependencies->add(['other', '<script>menu_focus("surveys_questions");</script>']);

?>

%{header}%


