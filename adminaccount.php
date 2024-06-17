<?php
include("adheader.php");
include("dbconnection.php");

session_start();
if(!isset($_SESSION['adminid'])){
    echo "<script>window.location='adminlogin.php';</script>";
}
// Fetch admin name from database
$adminid = $_SESSION['adminid'];
$sql_admin = "SELECT adminname FROM admin WHERE adminid='$adminid'";
$qsql_admin = mysqli_query($con, $sql_admin);
$row_admin = mysqli_fetch_assoc($qsql_admin);
$admin_name = $row_admin['adminname'];
?>

<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome , <?php echo $admin_name; ?></small>
    </div>

    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect" style="height: 300px;">
                <div class="icon"> <i class="zmdi zmdi-male-female col-blush"></i> </div>
                <div class="content">
                    <div class="text">Total Patient</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM patient WHERE status='Active'";
                        $qsql = mysqli_query($con,$sql);
                        $total_patients = mysqli_num_rows($qsql);
                        echo $total_patients;
                        ?>
                    </div>
                    <div class="text">Male Patients</div>
                    <div class="number">
                        <?php
                        $sql_male = "SELECT * FROM patient WHERE gender='Male' AND status='Active'";
                        $qsql_male = mysqli_query($con,$sql_male);
                        $male_patients = mysqli_num_rows($qsql_male);
                        echo $male_patients;
                        ?>
                    </div>
                    <div class="text">Female Patients</div>
                    <div class="number">
                        <?php
                        $sql_female = "SELECT * FROM patient WHERE gender='Female' AND status='Active'";
                        $qsql_female = mysqli_query($con,$sql_female);
                        $female_patients = mysqli_num_rows($qsql_female);
                        echo $female_patients;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account-circle col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Total Doctor </div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM doctor WHERE status='Active' ";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-account-box-mail col-blue"></i> </div>
                <div class="content">
                    <div class="text">Total Administrator</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM admin WHERE status='Active'";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon" > <i class="zmdi zmdi-money col-green" ></i> </div>
                <div class="content">
                    <div class="text">Revenue</div>
                    <div class="number">Ksh
                        <?php 
              $sql = "SELECT sum(bill_amount) as total  FROM `billing_records` ";
              $qsql = mysqli_query($con,$sql);
              while ($row = mysqli_fetch_assoc($qsql))
              { 
               echo $row['total'];
             }
              ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="col-lg-9 col-md-9 col-sm-12">
            <canvas id="pieChart" width=200" height="200"></canvas>
        </div>
    </div>

    <div class="clear"></div>
</div>
</div>

<?php
include("adfooter.php");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Male Patients', 'Female Patients'],
            datasets: [{
                data: [<?php echo $male_patients; ?>, <?php echo $female_patients; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            legend: {
                display: true,
                position: 'top',
            },
            title: {
                display: true,
                text: 'Patient Distribution by Gender'
            }
        }
    });
</script>
