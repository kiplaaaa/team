<?php
include("adformheader.php");
include("dbconnection.php");
session_start();

if (isset($_GET['delid']) && isset($_SESSION['adminid'])) {
    // Prepare statement to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM patient WHERE patientid = ?");
    $stmt->bind_param("i", $_GET['delid']);
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
        echo "<script>alert('Patient record deleted successfully.');</script>";
    }
    $stmt->close();
}
?>
<div class="container-fluid">
  <div class="block-header">
    <h2 class="text-center">View Patient Records</h2>
  </div>

  <div class="card">
    <section class="container">
      <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
          <tr>
            <th width="15%" height="36"><div align="center">Name</div></th>
            <th width="20%"><div align="center">Admission</div></th>
            <th width="28%"><div align="center">Address, Contact</div></th>    
            <th width="20%"><div align="center">Patient Profile</div></th>
            <th width="17%"><div align="center">Action</div></th>
          </tr>
        </thead>
        <tbody>
         <?php
         // Prepare statement to fetch data
         $stmt = $con->prepare("SELECT * FROM patient INNER JOIN appointment ON patient.patientid = appointment.patientid");
         $stmt->execute();
         $result = $stmt->get_result();
         
         while ($rs = $result->fetch_assoc()) {
            echo "<tr>
            <td>{$rs['patientname']}<br>
            <strong>Login ID:</strong> {$rs['loginid']}</td>
            <td>
            <strong>Date:</strong> &nbsp;{$rs['admissiondate']}<br>
            <strong>Time:</strong> &nbsp;{$rs['admissiontime']}</td>
            <td>{$rs['address']}<br>{$rs['city']} - &nbsp;{$rs['pincode']}<br>
            Mob No. - {$rs['mobileno']}</td>
            <td><strong>Blood group:</strong> - {$rs['bloodgroup']}<br>
            <strong>Gender:</strong> - &nbsp;{$rs['gender']}<br>
            <strong>DOB:</strong> - &nbsp;{$rs['dob']}</td>
            <td align='center'>Status - {$rs['status']}<br>";
            if (isset($_SESSION['adminid'])) {
              echo "<a href='patient.php?editid={$rs['patientid']}' class='btn btn-sm btn-raised bg-green'>Edit</a>
              <a href='viewpatient.php?delid={$rs['patientid']}' class='btn btn-sm btn-raised bg-blush' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a> 
              <hr>
              <a href='patientreport.php?patientid={$rs['patientid']}&appointmentid={$rs['appointmentid']}' class='btn btn-sm btn-raised bg-cyan'>View Report</a>";
            }
            echo "</td></tr>";
          }
          $stmt->close();
          ?>
        </tbody>
      </table>
    </section>
  </div>
</div>
<?php
include("adformfooter.php");
?>
