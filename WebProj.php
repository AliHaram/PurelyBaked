<!DOCTYPE html>
<html lang="en">

<head>
<?php
    session_start();
    $isLoggedIn = isset($_SESSION['user_id']); // Check if the user is logged in
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Events</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #333;
        }

        header {
            background-color: #0056b3;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 1.8rem;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 2rem;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffcc00;
        }

        main {
            position: relative;
        }

        video {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }

        .content-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            text-align: center;
            padding: 1rem 2rem;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }

        .content-overlay h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .content-overlay p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .cta-button {
            display: inline-block;
            padding: 0.8rem 2rem;
            background-color: #ffcc00;
            color: #0056b3;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #e6b800;
        }

        #about {
            background-color: #f4f4f4;
            padding: 3rem 2rem;
            text-align: center;
        }

        #about h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #0056b3;
        }

        #about p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
        }

        footer {
            background-color: #0056b3;
            color: #fff;
            padding: 1rem 2rem;
            text-align: center;
            margin-top: 2rem;
        }

        footer p {
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .content-overlay h1 {
                font-size: 2rem;
            }

            .content-overlay p {
                font-size: 1rem;
            }

            nav ul {
                flex-direction: column;
                align-items: flex-start;
            }

            nav ul li {
                margin: 0.5rem 0;
            }
        }


        /* Featured Events Section */
#featured-events {
    padding: 2rem 1rem;
    background-color: #fff;
    text-align: center;
}

#featured-events h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

/* Horizontal Scroll Styling */
.events-grid {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding: 1rem;
}

.events-grid div {
    min-width: 300px; /* Ensures each item is large enough for visibility */
    background: #f1f1f1;
    padding: 1rem;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    flex-shrink: 0; /* Prevents items from shrinking */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.events-grid div:hover {
    transform: scale(1.05); /* Slight enlargement */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Enhanced shadow */
}


/* Explore Events Section */
#explore-events {
    padding: 2rem 1rem;
    background-color: #f9f9f9;
    text-align: center;
}

#explore-events h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}


/* Meet the Team Section */
.meet-the-team {
    padding: 3rem 2rem;
    background-color: #f4f4f4;
    text-align: center;
}

.meet-the-team .section-title {
    font-size: 2.5rem;
    color: #0056b3;
    margin-bottom: 2rem;
    font-weight: bold;
}

.team-grid {
    display: flex;
    gap: 2rem;
    justify-content: center;
    flex-wrap: wrap;
}

.team-member {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    max-width: 300px;
    text-align: center;
    transition: transform 0.3s;
}

.team-member:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.team-photo {
    border-radius: 50%;
    width: 120px;
    height: 120px;
    object-fit: cover;
    margin-bottom: 1rem;
    border: 3px solid #ffcc00;
}

.team-member h4 {
    font-size: 1.5rem;
    color: #0056b3;
    margin-bottom: 0.5rem;
}

.team-member .role {
    font-size: 1rem;
    color: #777;
    margin-bottom: 1rem;
    font-style: italic;
}

.team-member p {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.social-links a {
    font-size: 0.9rem;
    color: #0056b3;
    text-decoration: none;
    margin: 0 0.5rem;
    transition: color 0.3s;
}

.social-links a:hover {
    color: #ffcc00;
}

/* Contact Us Section */
.contact_us {
    padding: 3rem 2rem;
    background-color: #f4f4f4;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
}

.bigContainer {
    display: flex;
    gap: 2rem;
    align-items: center; 
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.image-container,
.form-container {
    flex: 1; 
}

.image-container .mainImg {
    max-width: 100%;
    height: 550px;
    border-radius: 10px;
    display: block;
    margin: 0 auto;
}

.form-container {
    background-color: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.heading {
    font-size: 2rem;
    font-weight: bold;
    color: #0056b3;
    margin-bottom: 1.5rem;
    text-align: center;
}

.cardHead {
    font-size: 1rem;
    color: #555;
    margin-bottom: 0.5rem;
    display: block;
}

input, textarea {
    width: 100%;
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

input:focus, textarea:focus {
    border-color: #0056b3;
    outline: none;
}

.submit-button {
    background-color: #ffcc00;
    color: #0056b3;
    padding: 0.8rem 1.5rem;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
}

.submit-button:hover {
    background-color: #e6b800;
}

@media (max-width: 768px) {
    .bigContainer {
        flex-direction: column;
    }

    .image-container .mainImg {
        max-height: 200px;
    }
}
/* Subscription Section - Compact Design */
.subscribe {
    padding: 5vh 0;
    background: url('cookies.webp'); /* Adjusted position */
    background-size: cover;
    background-position: center -150px;
    position: relative;
    min-height: 50vh;
}


.subscribe:before {
    content: "";
    background: rgba(6, 12, 34, 0.6);
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.subscribe .container {
    position: relative;
    z-index: 2;
    max-width: 600px; /* Reduce container width */
    margin: 0 auto;
    text-align: center;
    color: #fff;
}

.subscribe .section-header h2 {
    font-size: 28px; /* Smaller heading */
    font-weight: 700;
    margin-bottom: 15px;
}

.subscribe .section-header p {
    font-size: 16px; /* Smaller paragraph text */
    color: #ddd;
    margin-bottom: 20px; /* Reduce margin */
}

.subscribe input {
    background: #fff;
    color: #060c22;
    border: none;
    outline: none;
    padding: 8px 15px; /* Smaller padding */
    border-radius: 30px;
    font-size: 14px;
    margin-right: 8px;
    width: calc(100% - 140px);
    max-width: 300px; /* Reduce input width */
}

.subscribe button {
    border: none;
    padding: 8px 20px; /* Smaller padding */
    background:  #ffcc00;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    border-radius: 30px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin: 10px;
}

.subscribe button:hover {
    background: #ffcc00;
}

/* Responsive Design */
@media only screen and (min-width: 768px) {
    .subscribe input {
        width: 65%;
    }
}

video {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.events-grid div {
    text-align: center;
}

.events-grid img {
    width: 100%; /* Makes the image adapt to the width of its container */
    height: 200px; /* Fixed height for all images */
    object-fit: cover; /* Ensures the image covers the space without distortion */
    border-radius: 8px; /* Optional: Keeps the rounded corners */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.events-grid img:hover {
    transform: scale(1.05); /* Slight zoom effect on hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow on hover */
}


#audio {
    background-color: #f4f4f4;
    padding: 2rem 1rem;
    text-align: center;
    border-top: 2px solid #0056b3;
}

.audio-message {
    font-size: 1.2rem;
    font-weight: bold;
    color: #0056b3;
    margin-top: 1rem;
}

.play-button {
    padding: 0.8rem 1.5rem;
    background-color: #0056b3;
    color: #fff;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.play-button:hover {
    background-color: #003f7d;
}

    </style>

</head>
<body>

    <header>
        <div class="logo">Purely Baked</div>
        <nav>
            <ul>
                <li><a href="index.html">Welcome</a></li>
                <li>
    <?php if ($isLoggedIn): ?>
        <a href="dashboard.php">My Cart</a>
    <?php else: ?>
        <a href="javascript:void(0)" onclick="redirectToLogin('dashboard.php')">My Cart</a>
    <?php endif; ?>
</li>

                
                <li><a href="gallery.html">Gallery</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <video autoplay muted loop playsinline>
            <source src="GingerVid.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="content-overlay">
            <h1>Welcome to Purely Baked</h1>
            <p>Enjoy and get better acquainted with our handcrafted delights.</p>
        </div>
    </main>

    <section id="audio">
    <button id="play-audio" class="play-button">Play Welcome Audio</button>
    <audio id="welcome-audio">
        <source src="purelybakedaudio.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
</section>
<script>
    document.getElementById('play-audio').addEventListener('click', function () {
    const audio = document.getElementById('welcome-audio');
    audio.play().catch(error => {
        console.error('Audio play failed:', error);
    });
});

    </script>




    

    <section id="featured-events">
    <h2 style="color: #0056b3">Upcoming Cookies!</h2>
    <div class="events-grid">
        <div>
            <img src="cookies.jpg" alt="Cookie" >
            <h3>Pistachio Infused Delight</h3>
        </div>
        <div>
            <img src="died.jpg" alt="Cookie" >
            <h3>Mega Chocolate Chunk</h3>
        </div>
        <div>
            <img src="yeet.jpg" alt="Cookie" >
            <h3>Classic Oatmeal Craze</h3>
        </div>
        <div>
            <img src="mega.webp" alt="Cookie" >
            <h3>Espresso Cocoa Fusion</h3>
        </div>
    </div>
</section>

<section id="explore-events">
    <h2 style="text-align: center; color: #0056b3;">Explore Cookies</h2>
    <div class="events-grid">
        <div>
            <img src="beard.jpg" alt="Cookie" >
            <h3>Big Papa</h3>
        </div>
        <div>
            <img src="tree.jpg" alt="Cookie" >
            <h3>Peanut Butter Perfection
            </h3>
        </div>
        <div>
            <img src="plain.jpg" alt="Cookie" >
            <h3>Zesty Lemon Crunch</h3>
        </div>
        <div>
            <img src="damn.jpg" alt="Cookie" >
            <h3>Raspberry Almond Crumble</h3>
        </div>
        <div>
            <img src="bandar.jpg" alt="Cookie" >
            <h3>Double Fudge Dream</h3>
        </div>
        <div>
            <img src="bamboo.jpg" alt="Cookie" >
            <h3>Our Mascott</h3>
        </div>
    </div>
</section>


    <section class="subscribe">
            <div class="container">
                <div class="section-header">
                    <h2>Newsletter</h2>
                </div>

                <div class="form">
                Stay in the loop with our latest gingerbread creations, seasonal specials, and delicious baking tips by signing up for our newsletter! Whether you’re looking for new cookie designs, festive gift ideas, or exclusive discounts, our monthly updates will keep you inspired and your pantry stocked with sweet treats. Don’t miss a crumb—join our newsletter family and let the homemade goodness of Purely Baked brighten your inbox!
                </div>
                <br>
                <form method="post" action="#">
                    <div class="form-row justify-content-center">
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="Enter your Email">
                        </div>
                        <div class="col-auto">
                            <button type="submit">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; Ali Haram 20220861, Zena Abu Rub 20220762. All rights reserved.</p>
    </footer>
    <script>
    function redirectToLogin(targetPage) {
        window.location.href = `login.php?redirect=${encodeURIComponent(targetPage)}&error=Please login to access this page.`;
    }
</script>

</body>
</html>






