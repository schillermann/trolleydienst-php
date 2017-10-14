<?php return ucwords(strtolower(trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))));
