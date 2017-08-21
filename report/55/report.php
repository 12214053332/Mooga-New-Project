<?php
//admin_3
session_start();
if(isset($_SESSION['userData'])){
    if(!in_array($_SESSION['userData']['userLevel'],[2])){
       include'errors/permissions.php';
        die();
    }
}else{
    header('Location: login.php');
}
include  ('../application/controller_base.class.php');
include  ('../application/Encryption.class.php');
include  ('../model/db.class.php');
include  ('../model/report.class.php');
$registry=null;
$report=new report();
$db =new  db($registry);
$db->getInstance();

$obj= $report->balance_spend();
$summary=$report->summary();
$projectsArr=$report->getProjectsDU();
/*print_r($projectsArr);
die();*/
$offersArr=$report->getOffersDU();
/*print_r($offersArr);
die();*/

?>
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Mooga | Rebort</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <link href="assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="assets/layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="assets/layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <style>
        .center {
            margin-top:50px;
        }

        .modal-header {
            padding-bottom: 5px;
        }

        .modal-footer {
            padding: 0;
        }

        .modal-footer .btn-group button {
            height:40px;
            border-top-left-radius : 0;
            border-top-right-radius : 0;
            border: none;
            border-right: 1px solid #ddd;
        }

        .modal-footer .btn-group:last-child > button {
            border-right: 0;
        }
    </style>
    <!-- END HEAD -->
    <body class="page-container-bg-solid">
            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->
                            <div class="page-head">
                                <div class="container">
                                    <!-- BEGIN PAGE TITLE -->
                                    <div class="page-title">
                                        <h1>Mooga
                                            <small>Report</small>
                                        </h1>
                                    </div>
                                    <!-- END PAGE TITLE -->
                                </div>
                            </div>
                            <!-- END PAGE HEAD-->
                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">
                                    <!-- BEGIN PAGE BREADCRUMBS -->
                                    <ul class="page-breadcrumb breadcrumb">
                                        <li>
                                            <a href="./">Moga</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <span>Report</span>
                                        </li>
                                        <li class="pull-right">
                                            <a href="logout.php">Logout</a>
                                        </li>
                                    </ul>
                                    <!-- END PAGE BREADCRUMBS -->
                                    <!-- BEGIN PAGE CONTENT INNER -->
                                    <div class="page-content-inner">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <h3 class="font-green-sharp">
                                                                <span data-counter="counterup" data-value="<?= $obj->artical?>">0</span>
                                                                <small class="font-green-sharp">Point</small>
                                                            </h3>
                                                            <small>Articles</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="icon-book-open"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 hidden">
                                                <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <h3 class="font-red-haze">
                                                                <span data-counter="counterup" data-value="<?= $obj->opportunity?>">0</span>
                                                                <small class="font-red-haze">Point</small>
                                                            </h3>
                                                            <small>Opportunities</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="icon-like"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <a data-toggle="modal" href="#projectsPoints">
                                                                <h3 class="font-blue-sharp">
                                                                    <span data-counter="counterup" data-value="<?= $obj->project?>">0</span>
                                                                    <small class="font-blue-sharp">Point</small>
                                                                </h3>

                                                            </a>
                                                            <div class="modal fade" id="projectsPoints">
                                                            	<div class="modal-dialog" style="width: 700px;">
                                                            		<div class="modal-content">
                                                            			<div class="modal-header">
                                                            				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            				<h4 class="modal-title">Projects Points (<?= $obj->project?>)</h4>
                                                            			</div>
                                                            			<div class="modal-body">
                                                                            <div class="table-responsive">
                                                                            	<table class="table table-hover">
                                                                            		<thead>
                                                                            			<tr>
                                                                            				<th class="text-center">#</th>
                                                                                            <th class="text-center"><a href="#" class="shortCount" data-type="project" data-id="projectsBodyData" data-short="desc">Count</a></th>
                                                                            				<th class="text-center">Name</th>
                                                                            				<th class="text-center">Short Description</th>

                                                                            			</tr>
                                                                            		</thead>
                                                                            		<tbody id="projectsBodyData">
                                                                                    <?php foreach($report->pointsCount('project') as $project){?>
                                                                                        <tr>
                                                                                            <td class="text-center"><?=$project->id?></td>
                                                                                            <td class="text-center"><?=$project->count?></td>
                                                                                            <td class="text-center"><p style=" width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?=$project->name?></p></td>
                                                                                            <td class="text-center"><p style=" width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?=$project->description?></p></td>
                                                                                        </tr>
                                                                                    <?php }?>

                                                                            		</tbody>
                                                                            	</table>
                                                                            </div>

                                                            			</div>
                                                            		</div><!-- /.modal-content -->
                                                            	</div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->
                                                            <small>Projects</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="icon-doc"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <h3 class="font-purple-soft">
                                                                <span data-counter="counterup" data-value="<?= $obj->user?>">0</span>
                                                                <small class="font-purple-soft">Point</small>
                                                            </h3>
                                                            <small>Users</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <div class="dashboard-stat2 ">
                                                    <div class="display">
                                                        <div class="number">
                                                            <a data-toggle="modal" href="#offersPoints">
                                                                <h3 class="font-red-haze">
                                                                    <span data-counter="counterup" data-value="<?= $obj->offer?>">0</span>
                                                                    <small class="font-red-haze">Point</small>
                                                                </h3>
                                                            </a>
                                                            <div class="modal fade" id="offersPoints">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title">Offers Points (<?= $obj->offer?>)</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-hover table-responsive">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th class="text-center"><a href="#" class="shortCount" data-type="offer" data-id="offersBodyData" data-short="desc">Count</a></th>
                                                                                        <th class="text-center">Short Description</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody id="offersBodyData">
                                                                                    <?php foreach($report->pointsCount('offer') as $offer){?>
                                                                                        <tr>
                                                                                            <td class="text-center"><?=$offer->id?></td>
                                                                                            <td class="text-center"><?=$offer->count?></td>
                                                                                            <td class="text-center"><?=$offer->description?></td>
                                                                                        </tr>
                                                                                    <?php }?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div><!-- /.modal -->

                                                            <small>Offers</small>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="icon-bag"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="portlet light ">
                                                    <div class="portlet-body">
                                                        <div class="row number-stats margin-bottom-30">
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-left">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> All Users </div>
                                                                        <div class="number"> <?=$summary->allusers?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-right">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar2"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> New Users </div>
                                                                        <div class="number"> <?=$summary->users?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-left hidden">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar3"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> All Opportunities </div>
                                                                        <div class="number"> <?=$summary->allopportunities?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-right hidden">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar4"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> New Opportunities </div>
                                                                        <div class="number"> <?=$summary->opportunities?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="clearfix" style="height:130px;"></div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-left">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar5"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> All Projects </div>
                                                                        <div class="number"> <?=$summary->allprojects?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-right">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar6"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> New Projects </div>
                                                                        <div class="number"> <?=$summary->projects?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                                <div class="stat-left">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar7"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> All Projects Viewed </div>
                                                                        <div class="number"> <?=$summary->allprojectsviewed?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                                <div class="stat-right">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar8"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> Deleted Projects </div>
                                                                        <div class="number"> <?=$summary->deletedprojects?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                                <div class="stat-right">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar9"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> <a href="#pendingProjects">Pending Projects</a></div>
                                                                        <div class="number"> <?=$summary->pendingprojects?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix" style="height: 130px;"></div>
                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-left">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar10"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> All Offers </div>
                                                                        <div class="number"> <?=$summary->alloffers?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-3 col-xs-6">
                                                                <div class="stat-right">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar11"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> New Offers </div>
                                                                        <div class="number"> <?=$summary->offers?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                                <div class="stat-left">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar12"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> All Offers Viewed </div>
                                                                        <div class="number"> <?=$summary->alloffersviewed?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                                <div class="stat-left">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar13"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"> Deleted Offers </div>
                                                                        <div class="number"> <?=$summary->deletedoffers?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                                <div class="stat-right">
                                                                    <div class="stat-chart">
                                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                                        <div id="sparkline_bar14"></div>
                                                                    </div>
                                                                    <div class="stat-number">
                                                                        <div class="title"><a href="#pendingOffers">Pending Offers</a></div>
                                                                        <div class="number"> <?=$summary->pendingoffers?> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h2 id="pendingProjects" class="text-center" style="color: #5c9bd1;">Pending Projects</h2>
                                                        </div>
                                                        <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-hover table-light">
                                                                <thead>
                                                                    <tr class="uppercase">
                                                                        <th class="text-center"> Type </th>
                                                                        <th class="text-center"> Numbers </th>
                                                                    </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td class="text-center"><span class="badge badge-empty badge-success"></span></td>
                                                                    <td class="text-center">
                                                                        <?php if($projectsArr->duplicated_active==0){?>
                                                                        <?= $projectsArr->duplicated_active?>
                                                                        <?php }else{?>
                                                                            <a data-toggle="modal" data-target="#duplicatedActiveProjects" ><?= $projectsArr->duplicated_active?></a>
                                                                            <!-- line modal -->
                                                                            <div class="modal fade" id="duplicatedActiveProjects" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                                            <h3 class="modal-title" id="lineModalLabel">Duplicated Active Projects</h3>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <table class="table table-hover table-responsive">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>ID</th>
                                                                                                    <th>Description</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php $x=1;foreach($projectsArr->duplicated_active_data as $data){?>
                                                                                                    <tr>
                                                                                                        <td><?= $x?></td>
                                                                                                        <td><?= $data->id?></td>
                                                                                                        <td><?php echo(substr_count($data->description,"\n")>1)?$data->description:substr($data->description, 0, 100);echo(strlen($data->description)>100&&substr_count($data->description,"\n")<1)?'...':'';?></td>
                                                                                                    </tr>
                                                                                                    <?php $x++;}?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                                                <div class="btn-group" role="group">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><span class="badge badge-empty badge-warning"></span></td>
                                                                    <td class="text-center">
                                                                        <?php if($projectsArr->duplicated==0){?>
                                                                            <?= $projectsArr->duplicated?>
                                                                        <?php }else{?>
                                                                            <a data-toggle="modal" data-target="#duplicatedProjects" ><?= $projectsArr->duplicated?></a>
                                                                            <!-- line modal -->
                                                                            <div class="modal fade" id="duplicatedProjects" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                                            <h3 class="modal-title" id="lineModalLabel">Duplicated Projects</h3>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <table class="table table-hover table-responsive">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>ID</th>
                                                                                                    <th>Description</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php $x=1;$descriptions=[];foreach($projectsArr->duplicated_data as $data){?>
                                                                                                    <tr>
                                                                                                        <td><?= $x?></td>
                                                                                                        <td><?= $data->id?></td>
                                                                                                        <td><?php echo(substr_count($data->description,"\n")>1)?$data->description:substr($data->description, 0, 100);echo(strlen($data->description)>100&&substr_count($data->description,"\n")<1)?'...':'';?></td>
                                                                                                        <td><?php if(!isset($descriptions[$data->description])){?><a href="#" data-type="projects" data-id="<?=$data->id?>" onclick="this.parent().parent().remove()" class="activeThis">Active</a><?php }?></td>
                                                                                                    </tr>
                                                                                                    <?php $x++;$descriptions[$data->description]=$data->description;}?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                                                <div class="btn-group" role="group">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><span class="badge badge-empty badge-danger"></span></td>
                                                                    <td class="text-center">
                                                                        <?php if($projectsArr->want_to_active==0){?>
                                                                            <?= $projectsArr->want_to_active?>
                                                                        <?php }else{?>
                                                                            <a data-toggle="modal" id="projectsWantToActiveNumbers" data-target="#wantToActiveProjects" ><?= $projectsArr->want_to_active?></a>
                                                                            <!-- line modal -->
                                                                            <div class="modal fade" id="wantToActiveProjects" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                                            <h3 class="modal-title" id="lineModalLabel">Want To Active Projects</h3>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div id="projectsActiveMessage"></div>
                                                                                            <table class="table table-hover table-responsive">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>ID</th>
                                                                                                    <th>Description</th>
                                                                                                    <th>Active</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php $x=1;foreach($projectsArr->want_to_active_data as $data){?>
                                                                                                    <tr id="projects-<?=$data->id?>">
                                                                                                        <td><?= $x?></td>
                                                                                                        <td><?= $data->id?></td>
                                                                                                        <td><?php echo(substr_count($data->description,"\n")>1)?$data->description:substr($data->description, 0, 100);echo(strlen($data->description)>100&&substr_count($data->description,"\n")<1)?'...':'';?></td>
                                                                                                        <td><a href="#" data-type="projects" data-id="<?=$data->id?>" class="activeThis">Active</a></td>
                                                                                                    </tr>
                                                                                                    <?php $x++;}?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                                                <div class="btn-group" role="group">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 text-center">
                                                                <span class="item-status">
                                                                    <span class="badge badge-empty badge-success"></span> Has One Active
                                                                </span>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                 <span class="item-status">
                                                                    <span class="badge badge-empty badge-warning"></span> Duplicated Not active
                                                                </span>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <span class="item-status">
                                                                    <span class="badge badge-empty badge-danger"></span> Want To Active
                                                                </span>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-12">
                                                            <h2 id="pendingOffers" class="text-center" style="color: #ffb848;">Pending Offers</h2>
                                                        </div>
                                                        <div class="table-scrollable table-scrollable-borderless">
                                                            <table class="table table-hover table-light">
                                                                <thead>
                                                                <tr class="uppercase">
                                                                    <th class="text-center">Type</th>
                                                                    <th class="text-center">Numbers</th>
                                                                </tr>
                                                                </thead>
                                                                <tr>
                                                                    <td class="text-center"><span class="badge badge-empty badge-success"></span></td>
                                                                    <td class="text-center">
                                                                        <?php if($offersArr->duplicated_active==0){?>
                                                                            <?= $offersArr->duplicated_active?>
                                                                        <?php }else{?>
                                                                            <a data-toggle="modal" data-target="#duplicatedActiveOffers" ><?= $offersArr->duplicated_active?></a>
                                                                            <!-- line modal -->
                                                                            <div class="modal fade" id="duplicatedActiveOffers" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                                            <h3 class="modal-title" id="lineModalLabel">Duplicated Active Offers</h3>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <table class="table table-hover table-responsive">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>ID</th>
                                                                                                    <th>Description</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php $x=1;foreach($offersArr->duplicated_active_data as $data){?>
                                                                                                    <tr>
                                                                                                        <td><?= $x?></td>
                                                                                                        <td><?= $data->id?></td>
                                                                                                        <td><?php echo(substr_count($data->description,"\n")>1)?$data->description:substr($data->description, 0, 100);echo(strlen($data->description)>100&&substr_count($data->description,"\n")<1)?'...':'';?></td>
                                                                                                    </tr>
                                                                                                    <?php $x++;}?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                                                <div class="btn-group" role="group">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><span class="badge badge-empty badge-warning"></span></td>
                                                                    <td class="text-center">
                                                                        <?php if($offersArr->duplicated==0){?>
                                                                            <?= $offersArr->duplicated?>
                                                                        <?php }else{?>
                                                                            <a data-toggle="modal" data-target="#duplicatedOffers" ><?= $offersArr->duplicated?></a>
                                                                            <!-- line modal -->
                                                                            <div class="modal fade" id="duplicatedOffers" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                                            <h3 class="modal-title" id="lineModalLabel">Duplicated Offers</h3>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <table class="table table-hover table-responsive">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>ID</th>
                                                                                                    <th>Description</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php $x=1;$descriptions=[];foreach($offersArr->duplicated_data as $data){?>
                                                                                                    <tr>
                                                                                                        <td><?= $x?></td>
                                                                                                        <td><?= $data->id?></td>
                                                                                                        <td><?php echo(substr_count($data->description,"\n")>1)?$data->description:substr($data->description, 0, 100);echo(strlen($data->description)>100&&substr_count($data->description,"\n")<1)?'...':'';?></td>
                                                                                                        <td><?php if(!isset($descriptions[$data->description])){?><a href="#" data-type="offers" onclick="this.parent().parent().remove()" data-id="<?=$data->id?>" class="activeThis">Active</a><?php }?></td>
                                                                                                    </tr>
                                                                                                    <?php $x++;$descriptions[$data->description]=$data->description;}?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                                                <div class="btn-group" role="group">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><span class="badge badge-empty badge-danger"></span></td>
                                                                    <td class="text-center">
                                                                        <?php if($offersArr->want_to_active==0){?>
                                                                            <?= $offersArr->want_to_active?>
                                                                        <?php }else{?>
                                                                            <a data-toggle="modal" id="offersWantToActiveNumbers" data-target="#wantToActiveOffers" ><?= $offersArr->want_to_active?></a>
                                                                            <!-- line modal -->
                                                                            <div class="modal fade" id="wantToActiveOffers" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                                            <h3 class="modal-title" id="lineModalLabel">Want To Active Offers</h3>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div id="offersActiveMessage"></div>
                                                                                            <table class="table table-hover table-responsive">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>#</th>
                                                                                                    <th>ID</th>
                                                                                                    <th>Description</th>
                                                                                                    <th>Active</th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php $x=1;foreach($offersArr->want_to_active_data as $data){?>
                                                                                                    <tr id="offers-<?=$data->id?>">
                                                                                                        <td><?= $x?></td>
                                                                                                        <td><?= $data->id?></td>
                                                                                                        <td><?php echo(substr_count($data->description,"\n")>1)?$data->description:substr($data->description, 0, 100);echo(strlen($data->description)>100&&substr_count($data->description,"\n")<1)?'...':'';?></td>
                                                                                                        <td><a href="#" data-type="offers" data-id="<?=$data->id?>" class="activeThis">Active</a></td>
                                                                                                    </tr>
                                                                                                    <?php $x++;}?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                                                                <div class="btn-group" role="group">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 text-center">
                                                                <span class="item-status">
                                                                    <span class="badge badge-empty badge-success"></span> Has One Active
                                                                </span>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                 <span class="item-status">
                                                                    <span class="badge badge-empty badge-warning"></span> Duplicated Not active
                                                                </span>
                                                            </div>
                                                            <div class="col-md-4 text-center">
                                                                <span class="item-status">
                                                                    <span class="badge badge-empty badge-danger"></span> Want To Active
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PAGE CONTENT INNER -->
                                </div>
                            </div>
                            <!-- END PAGE CONTENT BODY -->
                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->
                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>
        </div>
        <!--[if lt IE 9]>
        <script src="assets/global/plugins/respond.min.js"></script>
        <script src="assets/global/plugins/excanvas.min.js"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="assets/layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
       <!-- <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>-->
        <!-- END THEME LAYOUT SCRIPTS -->
    <script>
        $(document).on('click','.shortCount',function(){
            el=$(this);
            id=el.data('id');
            type=el.data('type');
            short=el.data('short');
            $.ajax({
                type: "POST",
                url: "changeShort.php",
                data: {"type": type, "short": short},
                success: function (msg) {
                    if(msg.success){
                        if(short=='desc'){
                            el.data('short','asc')
                        }else{
                            el.data('short','desc')
                        }
                        $("#"+id).html(msg.result);
                    }
                }
            });
        });
        $(document).on('click','.activeThis',function(e){
            e.preventDefault();
           type=$(this).attr('data-type');
            id=$(this).attr('data-id');
            console.log(type,id);
            $.ajax({
                method:"POST",
                url: "activeReport.php",
                data: {"type":type,"id":id},

            }).done(function(msg) {
                if(msg['success']==true){
                    if(type=='projects'){
                        $("#projectsActiveMessage").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>You Have Active Project Successfully</div>');
                        $("#projects-"+id).remove();
                        $("#projectsWantToActiveNumbers").html(parseInt($("#projectsWantToActiveNumbers").html())-1);
                    }else{
                        $("#offersActiveMessage").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>You Have Active Offer Successfully</div>');
                        $("#offers-"+id).remove();
                        $("#offersWantToActiveNumbers").html(parseInt($("#offersWantToActiveNumbers").html())-1);
                    }
                }
            });
        });
    </script>
    </body>

</html>