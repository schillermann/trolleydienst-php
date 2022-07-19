<?php
$placeholder = require('../includes/init_page.php');

if(isset($_POST['save'])) {
	App\Tables\Reports::delete_old_entries($database_pdo);

	$date_from = require('../filters/post_date_from.php');

	$merge_date_and_time = include '../modules/merge_date_and_time.php';
	$shift_datetime_from = $merge_date_and_time($date_from, $_POST['time_from']);

	$report = new App\Models\Report(
		(int)$_POST['id_shift_type'],
		App\Tables\Publisher::select_name($database_pdo, (int)$_POST['id_user']),
		require('../filters/post_route.php'),
		(int)$_POST['book'],
		(int)$_POST['brochure'],
		(int)$_POST['bible'],
		(int)$_POST['magazine'],
		(int)$_POST['tract'],
		(int)$_POST['address'],
		(int)$_POST['talk'],
        require('../filters/post_publisher_note.php'),
		$shift_datetime_from
	);
	if(App\Tables\Reports::insert($database_pdo, $report))
		$placeholder['message']['success'] = __('Your report has been saved.');
	else
		$placeholder['message']['error'] = __('Your report could not be saved!');
}

$placeholder['user_list'] = App\Tables\Publisher::select_all($database_pdo);
$placeholder['route_list'] = App\Tables\Shifts::select_route_list($database_pdo, 1);
$placeholder['shifttype_list'] = App\Tables\ShiftTypes::select_all($database_pdo);

$render_page = require('../includes/render_page.php');
echo $render_page($placeholder);