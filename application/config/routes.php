<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['logout'] = 'pages/logout';
$route['temp/forgotpw'] = 'temp/forgotpw';
$route['pages/submitPass'] = 'pages/submitPass';
$route['default_controller'] = 'pages';
$route['forgot/(:any)'] = 'pages/checkpw/$1';
//------------START ADMIN--------------------//

$route['pages'] = 'pages';
$route['pages/submit'] = 'pages/submit';
$route['pages/login'] = 'pages/login';
$route['pages/link/(:any)'] = 'pages/link/$1';
$route['pages/courselist'] = 'pages/courselist';
$route['pages/search_find'] = 'pages/search_find';
$route['pages/login_enroll'] = 'pages/login_enroll';

$route['pages/aboutus'] = 'pages/aboutus';
$route['validate/(:any)'] = 'pages/validate/$1';
$route['viewPermission/(:any)'] = 'pages/viewPermission/$1/$2';
$route['givePermission/(:any)'] = 'pages/givePermission/$1/$2/$3';
$route['confirmRequest/(:any)'] = 'pages/confirmRequest/$1/$2/$3';
$route['finalStepRequest/(:any)'] = 'pages/finalStepRequest/$1/$2';
$route['changePassword/(:any)'] = 'pages/changePassword/$1';

$route['managers/status'] = 'managers/status';
$route['managers/promote'] = 'managers/promote';
$route['managers/create'] = 'managers/create';
$route['managers/delete'] = 'managers/delete';
$route['managers/(:any)'] = 'managers/view/$1';
$route['managers/search_results'] = 'managers/search_results';

$route['course/printS'] = 'course_temp/printS';
$route['course/printEventForms'] = 'course_temp/printEventForms';
$route['course/add'] = 'course_temp/add';
$route['course/search_upload'] = 'course_temp/search_upload';
$route['course/reports_chart'] = 'course_temp/reports_chart';
$route['course/upload'] = 'course_temp/upload';
$route['course/untagRefund'] = 'course_temp/untagRefund';
$route['course/edit'] = 'course_temp/edit';
$route['course/deletePending'] = 'course_temp/deletePending';
$route['course/addRequest'] = 'course_temp/addRequest';
$route['course/approve'] = 'course_temp/approve';
$route['course/save'] = 'course_temp/save';
$route['course/addition'] = 'course_temp/addition';
$route['course/reports'] = 'course_temp/reports';
$route['course/reports_search'] = 'course_temp/reports_search';
$route['course/cancelledStatus'] = 'course_temp/cancelledStatus';
$route['course/cancelled_find/(:any)'] = 'course_temp/cancelled_find/$1';
$route['course/cancelled'] = 'course_temp/cancelled';
$route['course/search_cancelled'] = 'course_temp/search_cancelled';
$route['course/search_find'] = 'course_temp/search_find';
$route['course/cancelled/(:any)'] = 'course_temp/seeCancelled/$1';
$route['course/process/(:any)'] = 'course_temp/process/$1';
$route['course/printOne'] = 'course_temp/printOne';
$route['course/SURVEY'] = 'course_temp/SURVEY';
$route['course/upSig'] = 'course_temp/upSig';
$route['course/editSig'] = 'course_temp/editSig';
$route['course/viewCat'] = 'course_temp/viewCat';
$route['course/addCategories'] = 'course_temp/addCategories';
$route['course/viewQuestions'] = 'course_temp/viewQuestions';
$route['course/saveQuestions'] = 'course_temp/saveQuestions';
$route['course/addQuestions'] = 'course_temp/addQuestions';
$route['course/search_survey'] = 'course_temp/search_survey';
$route['course/resultEval/(:any)'] = 'course_temp/resultEval/$1/$2';
$route['course/resultOrigSurvey/(:any)'] = 'course_temp/resultOrigSurvey/$1/$2';
$route['course/editCategory'] = 'course_temp/editCategory';
$route['course/delCategories'] = 'course_temp/delCategories';
$route['course/printResult'] = 'course_temp/printResult';
$route['course/downloadReports'] = 'course_temp/downloadReports';
$route['course/request'] = 'course_temp/request';
$route['course/search_request'] = 'course_temp/search_request';
$route['course/sendEmail'] = 'course_temp/sendEmail';
$route['course/setSurvey'] = 'course_temp/setSurvey';
$route['course/seeRequest/(:any)'] = 'course_temp/seeRequest/$1/$2';
$route['course/origsurveyResult'] = 'course_temp/origsurveyResult';
$route['course/downloadBatch/(:any)'] = 'course_temp/downloadBatch/$1';
$route['course/participantReport/(:any)'] = 'course_temp/participantReport/$1';
$route['course/changeForms_pending'] = 'course_temp/changeForms_pending';
$route['course'] = 'course_temp';

$route['adminprofile'] = 'adminprofile';

$route['adminhome/(:any)'] = 'adminhome/index';
$route['adminhome'] = 'adminhome';

$route['participant/(:any)'] = 'participant/view/$1';
$route['participant'] = 'participant';
$route['participant/printAttendance'] = 'participant/printAttendance';
$route['participant/search_users'] = 'participant/search_users';
$route['participant/addStudent'] = 'participant/addStudent';
$route['participant/viewprofile'] = 'participant/viewprofile';

$route['validation/search_results'] = 'validation/search_results';
$route['validation/validate'] = 'validation/validate/$1/$2';
$route['validation/payment'] = 'validation/payment/$1/$2';
$route['validation/record'] = 'validation/record/$1/$2';
$route['validation/changeForms'] = 'validation/changeForms';
$route['validation'] = 'validation';

$route['settings/(:any)'] = 'adminsettings/index/$1';
$route['adminchange'] = 'adminsettings/changeform';
$route['adminchangepword/(:any)'] = 'adminsettings/forgotform/$1';
$route['adminsettings/change'] = 'adminsettings/change';
$route['adminsettings/forgot'] = 'adminsettings/forgot';

//------------END ADMIN--------------------//


$route['managerprofile'] = 'managerprofile';

$route['managerhome'] = 'managerhome';

$route['managerparticipant/(:any)'] = 'managerparticipant/view/$1';
$route['managerparticipant'] = 'managerparticipant';
$route['managerparticipant/search_users'] = 'managerparticipant/search_users';
$route['managerparticipant/viewprofile'] = 'managerparticipant/viewprofile';

$route['managervalidation/search_results'] = 'managervalidation/search_results';
$route['managervalidation/validate'] = 'managervalidation/validate/$1/$2';
$route['managervalidation/payment'] = 'managervalidation/payment/$1/$2';
$route['managervalidation'] = 'managervalidation';

$route['managercourse/add'] = 'managercourse/add';
$route['managercourse/upSig'] = 'managercourse/upSig';
$route['managercourse/search_upload'] = 'managercourse/search_upload';
$route['managercourse/reports'] = 'managercourse/reports';
$route['managercourse/participantReport'] = 'managercourse/participantReport';
$route['managercourse/reports_search'] = 'managercourse/reports_search';
$route['managercourse/cancelledStatus'] = 'managercourse/cancelledStatus';
$route['managercourse/cancelled'] = 'managercourse/cancelled';
$route['managercourse/search_find'] = 'managercourse/search_find';
$route['managercourse/search_cancelled'] = 'managercourse/search_cancelled';
$route['managercourse/cancelled/(:any)'] = 'managercourse/seeCancelled/$1';
$route['managercourse/process/(:any)'] = 'managercourse/process/$1';
$route['managercourse'] = 'managercourse';
$route['managercourse/upload'] = 'managercourse/upload';

//------------START PARTICIPANT--------------------//

$route['participantprofile/(:any)'] = 'participantprofile/view/$1';
$route['participantprofile'] = 'participantprofile';
$route['participantprofile/updateDetails'] = 'participantprofile/updateDetails';
$route['participantprofile/updateShortForm'] = 'participantprofile/updateShortForm';
$route['participantprofile/password'] = 'participantprofile/password';

$route['participantcourse/(:any)'] = 'participantcourse/view/$1';
$route['participantcourse'] = 'participantcourse/index';


$route['participantcourse/upcoming'] = 'participantcourse/upcoming';
$route['participantcourse/survey'] = 'participantcourse/survey';
$route['participantcourse/certGen'] = 'participantcourse/certGen';
$route['participantcourse/formSurvey'] = 'participantcourse/formSurvey';
$route['participantcourse/origsurvey'] = 'participantcourse/origsurvey';
$route['participantcourse/formOrigSurvey'] = 'participantcourse/formOrigSurvey';
$route['participantcourse/completed'] = 'participantcourse/completed';
$route['participantcourse/cancelled'] = 'participantcourse/cancelled';
$route['participantcourse/search_reserved'] = 'participantcourse/search_reserved';
$route['participantcourse/search_upcoming'] = 'participantcourse/search_upcoming';
$route['participantcourse/search_completed'] = 'participantcourse/search_completed';
$route['participantcourse/search_find'] = 'participantcourse/search_find';
$route['participantcourse/reserved'] = 'participantcourse/reserved';
$route['participantcourse/unreserved'] = 'participantcourse/unreserved';
$route['participantcourse/unreservedres'] = 'participantcourse/unreservedres';
$route['participantcourse/view'] = 'participantcourse/view';
$route['participantcourse/sendPermission'] = 'participantcourse/sendPermission';

$route['participantsettings'] = 'participantsettings/index';
$route['change'] = 'participantsettings/changeform';
$route['changepword'] = 'participantsettings/forgotform';
$route['participantsettings/forgot'] = 'participantsettings/forgot';
$route['participantsettings/change'] = 'participantsettings/change';

$route['participantuser/(:any)'] = 'participantuser/view/$1';
$route['participantuser'] = 'participantuser';

//------------END PARTICIPANT--------------------//
/* End of file routes.php */
/* Location: ./application/config/routes.php */