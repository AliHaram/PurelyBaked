<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php?error=Please login to access the dashboard.");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "events_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's details
$user_id = $_SESSION['user_id'];
$user_name = htmlspecialchars($_SESSION['user_name']);

// Fetch registered events for the user
$sql = "
    SELECT events.title, events.description, events.location, events.start_date, events.start_time, events.end_time
    FROM registrations
    INNER JOIN events ON registrations.event_id = events.id
    WHERE registrations.user_id = $user_id
    ORDER BY events.start_date, events.start_time
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Combine styles from both files */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
            background-color: #f0f4fa;
        }

        .dashboard {
            display: flex;
            width: 100%;
        }

        .sidebar {
            width: 20%;
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            background: #3498db;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            color: #3498db;
            text-decoration: none;
        }

        .events-section {
            margin-top: 30px;
        }

        .event-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 1rem;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .event-card h2 {
            margin-top: 0;
            color: #00264d;
        }

        .event-card p {
            margin: 0.5rem 0;
        }

        .no-events {
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Menu</h2>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="events.html">Explore Events</a></li>
                    <li><a href="my_events.html">My Events</a></li>
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Welcome back, <?php echo $user_name; ?>!</h1>
                <p>Discover your dashboard insights below.</p>
            </header>

            <!-- Dashboard Cards -->
            <section class="dashboard-cards">
                <div class="card">
                    <h3>Upcoming Events</h3>
                    <p>Check out the events you've registered for.</p>
                    <a href="events.html">View Events</a>
                </div>
                <div class="card">
                    <h3>Create an Event</h3>
                    <p>Host a new event for the community.</p>
                    <a href="create_event.html">Create Now</a>
                </div>
                <div class="card">
                    <h3>Manage Profile</h3>
                    <p>Update your personal details and preferences.</p>
                    <a href="profile.html">Edit Profile</a>
                </div>
            </section>

            <!-- Events Section -->
            <section class="events-section" id="events-section">
                <h2>Registered Events</h2>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="event-card">
                            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($row['start_date']); ?></p>
                            <p><strong>Time:</strong> <?php echo htmlspecialchars($row['start_time']); ?> - <?php echo htmlspecialchars($row['end_time']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-events">You have not registered for any events yet.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>

</html>

<?php
$conn->close();
?>
