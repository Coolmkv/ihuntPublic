<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']                =       'home';
//$route['default_controller']                =       'Login/register';
$route['404_override'] = '';
$route['translate_uri_dashes']              =       FALSE;
$route['LoginOrRegister']                   =       'Login/register';
$route['OrganizationDetails/(:any)']        =       'home/orgDetails/$1';
$route['studentDashboard']                  =       'student/index';
$route['studentProfile']                    =       'student/profile';
$route['studentPersonalDetails']            =       'student/editpersonalprofile';
$route['studentSecondarySchoolDetails']     =       'student/editsecondarySchoolInfo';
$route['studentSenSecondarySchoolDetails']  =       'student/editsrsecondarySchoolInfo';
$route['studentHigherEducationDetails']     =       'student/edithigherInfo';
$route['studentExperienceDetails']          =       'student/experience';
$route['studentJobPreferenceDetails']       =       'student/studentJobProfile';
$route['studentReferenceDetails']           =       'student/referes';
$route['allOrganizationDetails']            =       'home/allOrganizations';
$route['compareOrganization']               =       'home/comapreOrganizations';
$route['studentCompetitiveExamDetails']     =       'student/competitiveExamDetails';
$route['organizationsCategories']           =       'home/filterByCat';
$route['studentUploadRelatedDocuments']     =       'student/uploadDocuments';
$route['studentInstituteExamDetails'] = 'student/instituteExamDetails';
$route['AdvertiseWithUs']                   =       'home/Advertise';
$route['forgotpassword']                    =       'home/forgotpassword';
$route['OurTeam']                           =       'home/ourTeam';
$route['CareerWithUs']                      =       'home/carrer';
$route['myApplications']                    =       'student/myApplications';
$route['myNotifications']                   =       'student/myNotifications';
$route['faq']                               =       'home/faq';
$route['testimonial'] = 'home/testimonial';
$route['blog'] = 'home/blog';
$route['privacypolicy'] = 'home/privacyPolicyPage';