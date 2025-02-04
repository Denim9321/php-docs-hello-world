<?php
// This file can contain PHP code if needed for dynamic content generation, 
// like pulling course offerings from a database or processing form submissions.
// For now, it's a static landing page with minimal PHP.

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Offerings</title>
  <style>
    /* Reset default margin and padding */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body and overall layout */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      color: #333;
      line-height: 1.6;
    }

    header {
      background: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    header h1 {
      font-size: 2.5em;
    }

    header p {
      font-size: 1.2em;
      margin-top: 10px;
    }

    h2 {
      text-align: center;
      font-size: 2em;
      margin-top: 20px;
    }

    #courses {
      display: flex;
      justify-content: space-around;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .course {
      background-color: #fff;
      padding: 20px;
      width: 30%;
      margin: 10px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .course h3 {
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    .course p {
      font-size: 1em;
      margin-bottom: 20px;
    }

    button {
      background-color: #28a745;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 1em;
      cursor: pointer;
      border-radius: 5px;
    }

    button:hover {
      background-color: #218838;
    }

    #promotion {
      background-color: #ffeb3b;
      padding: 20px;
      text-align: center;
      margin-top: 40px;
      border-radius: 8px;
    }

    footer {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 10px;
      margin-top: 40px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      #courses {
        flex-direction: column;
        align-items: center;
      }

      .course {
        width: 80%;
        margin: 10px 0;
      }
    }
  </style>
</head>

<body>
  <header>
    <h1>Welcome to Our Course Offerings!</h1>
    <p>Explore our courses and grab exciting promotions today!</p>
  </header>

  <section id="courses">
    <h2>Our Courses</h2>
    <?php
      // PHP code to dynamically list courses (optional)
      $courses = [
        ['title' => 'Web Development Bootcamp', 'description' => 'Learn HTML, CSS, JavaScript, and more to become a full-stack web developer.'],
        ['title' => 'Data Science Essentials', 'description' => 'Get started with Python, data analysis, and machine learning.'],
        ['title' => 'Digital Marketing Mastery', 'description' => 'Master SEO, Google Ads, and social media marketing techniques.'],
      ];

      foreach ($courses as $course) {
        echo "
        <div class='course'>
          <h3>{$course['title']}</h3>
          <p>{$course['description']}</p>
          <button class='enroll-btn'>Enroll Now</button>
        </div>";
      }
    ?>
  </section>

  <section id="promotion">
    <h2>Limited Time Offer</h2>
    <p>Sign up for any course and get a 20% discount with the code <strong>PROMO20</strong>!</p>
    <button class="cta-btn">Claim Discount
