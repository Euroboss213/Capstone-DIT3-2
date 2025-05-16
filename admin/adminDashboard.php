<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php";

// Get the user's name from session
$tables = ['certresidency', 'permit', 'good_moral', 'indigency'];
$record_counts = [];

foreach ($tables as $table) {
    $query = "SELECT COUNT(*) AS count FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $record_counts[$table] = $row['count'] ?? 0;
}

$query = "SELECT 
            SUM(sex = 'Male') AS male_count,
            SUM(sex = 'Female') AS female_count,
            SUM(pwd = 'Yes') AS pwd_count,
            SUM(indigent = 'Yes') AS indigent_count,
            SUM(solo_parent = 'Yes') AS solo_count,
            SUM(civil_status = 'Single') AS single_count,
            SUM(civil_status = 'Married') AS married_count,
            SUM(member_4ps = 'Yes') AS members_4ps_count,
            SUM(covid_status = 'Positive') AS covid_positive_count,
            SUM(covid_status = 'Negative') AS covid_negative_count,
            SUM(vaccinated = 'Yes') AS vaccinated_count
          FROM residences";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminDashboard_style.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../js/adminDashboard.js" defer></script>
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/unread_to_read_notif.js" defer></script>
</head>
<body>
  <!-- Navbar -->
  <?php include '../components/admin_nav.php'; ?>
 <!-- Notification Modal -->
 <?php include 'adminNotif.php'; ?>
 
  <div class="flex-container">
    <!-- Sidebar -->
    <?php include '../components/admin_side.php'; ?>

    <!-- Main Content -->
   <main class="main-content">
 <div class="dashboard-container">
  <!-- Sex Demographic -->
  <div class="dashboard-card card-flex">
    <div class="card-icon bg-blue-500">
      <i class="fas fa-venus-mars"></i>
    </div>
    <div class="card-content">
      <h3 class="card-title">Sex Demographic</h3>
      <p class="card-desc"></p>
      <div class="value-group">
        <span class="value male">Male: <?php echo $data['male_count']; ?></span>
        <span class="value female">Female: <?php echo $data['female_count']; ?></span>
      </div>
    </div>
  </div>

  <!-- PWD Count -->
  <div class="dashboard-card card-flex">
    <div class="card-icon bg-green-500">
      <i class="fas fa-wheelchair"></i>
    </div>
    <div class="card-content">
      <h3 class="card-title">PWD Residents</h3>
      <p class="card-desc"></p>
      <div class="value-group">
        <span class="value"><?php echo $data['pwd_count']; ?> PWDs</span>
      </div>
    </div>
  </div>

  <!-- Solo Parents -->
  <div class="dashboard-card card-flex">
    <div class="card-icon bg-yellow-500">
      <i class="fas fa-user-friends"></i>
    </div>
    <div class="card-content">
      <h3 class="card-title">Solo Parents</h3>
      <p class="card-desc"></p>
      <div class="value-group">
        <span class="value"><?php echo $data['solo_count']; ?> Solo Parent(s)</span>
      </div>
    </div>
  </div>

  <!-- Civil Status -->
  <div class="dashboard-card card-flex">
    <div class="card-icon bg-red-500">
      <i class="fas fa-heart"></i>
    </div>
    <div class="card-content">
      <h3 class="card-title">Civil Status</h3>
      <p class="card-desc"></p>
      <div class="value-group">
        <span class="value">Single: <?php echo $data['single_count']; ?></span>
        <span class="value">Married: <?php echo $data['married_count']; ?></span>
      </div>
    </div>
  </div>

  <!-- Indigent Count -->
    <div class="dashboard-card card-flex">
      <div class="card-icon bg-purple-500">
        <i class="fas fa-hand-holding-heart"></i>
      </div>
      <div class="card-content">
        <h3 class="card-title">Indigent Residents</h3>
        <p class="card-desc"></p>
        <div class="value-group">
          <span class="value"><?php echo $data['indigent_count']; ?> Indigent(s)</span>
        </div>
      </div>
    </div>

    <div class="dashboard-card card-flex">
  <div class="card-icon bg-indigo-500">
    <i class="fas fa-handshake-angle"></i>
  </div>
  <div class="card-content">
    <h3 class="card-title">4Ps Members</h3>
    <p class="card-desc"></p>
    <div class="value-group">
      <span class="value"><?php echo $data['members_4ps_count']; ?> Member(s)</span>
    </div>
  </div>
</div>

<div class="dashboard-card card-flex">
  <div class="card-icon bg-orange-500">
    <i class="fas fa-virus-covid"></i>
  </div>
  <div class="card-content">
    <h3 class="card-title">COVID Status</h3>
    <p class="card-desc"></p>
    <div class="value-group">
      <span class="value">Positive: <?php echo $data['covid_positive_count']; ?></span>
      <span class="value">Negative: <?php echo $data['covid_negative_count']; ?></span>
    </div>
  </div>
</div>

<div class="dashboard-card card-flex">
  <div class="card-icon bg-teal-500">
    <i class="fas fa-syringe"></i>
  </div>
  <div class="card-content">
    <h3 class="card-title">Vaccinated Residents</h3>
    <p class="card-desc"></p>
    <div class="value-group">
      <span class="value"><?php echo $data['vaccinated_count']; ?> Vaccinated</span>
    </div>
  </div>
</div>
<!-- Hidden Span Elements for Document Requests Counts -->
<span id="certresidencyCount" style="display: none;"><?php echo $record_counts['certresidency']; ?></span>
<span id="permitCount" style="display: none;"><?php echo $record_counts['permit']; ?></span>
<span id="goodMoralCount" style="display: none;"><?php echo $record_counts['good_moral']; ?></span>
<span id="indigencyCount" style="display: none;"><?php echo $record_counts['indigency']; ?></span>

<div class="dashboard-card" id="graphCard">
  <canvas id="documentGraph"></canvas>
</div>
</div>

</main>

  </div>
</body>
</html>
