<?php
error_reporting(0);
ini_set("display_errors", 0);
session_start();
if(empty($_SESSION["user_name"])) {
    $msg="Try to login first";
    $msg=base64_encode($msg);
    header("Location: index.php?warn=$msg");
    die();
}
$user_name = $_SESSION["user_name"];
require_once("include/class.MySQL.php");
require_once('include/config.php');
$MySQL = new MySQL(DB_NAME, USER_NAME, PASSWORD, HOST);

$results = $MySQL->Select('servers');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard :: Server Checker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/jquery1.9.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Nav Bar -->
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="dashboard.php" class="navbar-brand">Server Checker</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav pull-right navbar-nav" id="big-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="projects">
                        <?php echo $user_name; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="projects">
                        <!--<li><a tabindex="-1" href="#">Change Password</a></li>-->
                        <li><a tabindex="0" href="log/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <!--<li id="mobile-view">
                    <a href="#">Change Password</a>
                </li>-->
                <li id="mobile-view">
                    <a href="log/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="page-header"></div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12">
            <div style="width:90%;margin: 0px auto 0;">
                <div>
                    <h1 class="text-info">Servers</h1>
                </div>
                <?php
                    if(isset($_SESSION['msg'])) {
                        $msg = $_SESSION['msg'];
                        $status = $_SESSION['status'];
                        unset($_SESSION['msg']);
                        unset($_SESSION['status']);
                        if($status == 1) {
                            echo '<div class="alert alert-success fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p>'.$msg.'</p>
                             </div>';
                        } else {
                            echo '<div class="alert alert-danger fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p>'.$msg.'</p>
                             </div>';
                        }
                    }
                if(isset($_GET['msg'])) {
                    echo '<div class="alert alert-success fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>'.base64_decode($_GET['msg']).'</p>
                         </div>';
                }
                ?>

                <div class="clearfix"></div>
                <div style="margin: 0 0 10px 0;width: 100%">
                    <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Add New Server</a>
                    <a href="dashboard.php" class="btn btn-info"><span class="glyphicon glyphicon-refresh"></span> Reload</a>
                </div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Server Name</th>
                            <th>IP Address</th>
                            <th>Port</th>
                            <th>Provider Name</th>
                            <th>Provider Email</th>
                            <th>Provider Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($results[0]['id'] == null)
                                $final_results[0] = $results;
                            else
                                $final_results = $results;
                            foreach($final_results as $result) {
                                $status = 'Down';
                                $class = 'btn-danger';
                                if($result['status'] == 1) {
                                    $status = 'Up';
                                    $class = 'btn-success';
                                }
                                echo '<tr>';
                                echo '<td>'.$result['server_name'].'</td>';
                                echo '<td>'.$result['ip_address'].'</td>';
                                echo '<td>'.$result['port'].'</td>';
                                echo '<td>'.$result['provider'].'</td>';
                                echo '<td>'.$result['email'].'</td>';
                                echo '<td>'.$result['phone'].'</td>';
                                echo '<td><button type="button" class="btn '.$class.' btn-sm">'.$status.'</button></td>';
                                echo '<td>
                                    <a href="delete.php?id='.$result['id'].'" title="Delete">
                                        <span class="glyphicon glyphicon-remove text-danger"></span>
                                    </a>
                                     </td>';
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                    <div></div>
                </div>

            </div>
        </div>
    </div>
    <footer>
        <div style="margin-top: 100px;">
            <div class="row">
                <div class="col-xs-12" style="height: 50px;background-color: #222222;padding: 10px;color: #fff;">
                    Copyright 2014
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New Server</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="serverName">Server Name</label>
                        <input type="text" class="form-control" id="serverName" name="serverName" placeholder="Enter Server Name">
                    </div>
                    <div class="form-group">
                        <label for="ipAddress">IP</label>
                        <input type="text" class="form-control" id="ipAddress" name="ipAddress" placeholder="IP">
                    </div>
                    <div class="form-group">
                        <label for="port">Port</label>
                        <input type="text" class="form-control" id="port" name="port" placeholder="Port">
                    </div>
                    <div class="form-group">
                        <label for="provider">Provider</label>
                        <input type="text" class="form-control" id="provider" name="provider" placeholder="Provider">
                    </div>
                    <div class="form-group">
                        <label for="email">Provider Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Provider Email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Provider Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Provider Phone">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="serverInfoSave" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#serverInfoSave").click(function(){
        var serverName = $("#serverName").val();
        var ipAddress = $("#ipAddress").val();
        var port = $("#port").val();
        var provider = $("#provider").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        $.post( "save_server_data.php", { serverName: serverName, ipAddress: ipAddress, port: port, provider: provider, email: email, phone: phone }, function() {
            $('#myModal').modal('hide');
            setTimeout(function (){
                location.reload();
            }, 3000);

        });
    });
</script>

</body>
</html>