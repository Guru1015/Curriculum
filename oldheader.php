<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Responsive Navbar | CodingNepal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
      * {
        padding: 0;
        margin: 0;
        text-decoration: none;
        list-style: none;
        box-sizing: border-box;
      }
      body {
        font-family: 'Times New Roman', Times, serif;
      }
      nav {
        background: #0082e6;
        height: 140px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
      }
      .logo-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 100%;
      }
      label.logo {
        color: white;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      label.logo img {
        margin-right: 15px;
        height: 100px;
        width: 100px;
      }
      nav ul {
        display: flex;
        align-items: center;
        margin-right: 20px;
      }
      nav ul li {
        display: inline-block;
        line-height: 80px;
        margin: 0 5px;
      }
      nav ul li a {
        color: white;
        font-size: 17px;
        padding: 7px 13px;
        border-radius: 3px;
        text-transform: uppercase;
      }
      a.active, a:hover {
        background: #1b9bff;
        transition: .5s;
      }
      .checkbtn {
        font-size: 30px;
        color: white;
        display: none;
      }
      #check {
        display: none;
      }
      @media (max-width: 952px) {
        label.logo {
          font-size: 18px;
        }
        nav ul li a {
          font-size: 16px;
        }
      }
      @media (max-width: 858px) {
        nav {
          height: auto;
          flex-direction: column;
          padding: 20px;
        }
        .checkbtn {
          display: block;
          cursor: pointer;
        }
        ul {
          position: fixed;
          width: 100%;
          height: 100vh;
          background: #2c3e50;
          top: 0;
          left: -100%;
          text-align: center;
          transition: all .5s;
          display: flex;
          flex-direction: column;
          justify-content: center;
        }
        nav ul li {
          display: block;
          margin: 20px 0;
          line-height: 30px;
        }
        nav ul li a {
          font-size: 20px;
        }
        a:hover, a.active {
          background: none;
          color: #0082e6;
        }
        #check:checked ~ ul {
          left: 0;
        }
        .logo-container {
          align-items: center;
          text-align: center;
          margin-bottom: 20px;
        }
        label.logo {
          flex-direction: column;
          align-items: center;
          text-align: center;
        }
        label.logo img {
          margin: 0 0 10px 0;
        }
      }
      section {
        background: url(bg1.jpg) no-repeat;
        background-size: cover;
        height: calc(100vh - 80px);
      }
    </style>
  </head>
  <body>
    <nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <div class="logo-container">
        <label class="logo">
          <img class="logo1" src="New folder/5.png" alt="Logo">
          Sri Krishna Arts and Science College <br>(An Autonomous Institution)<br>Affiliated to Bharatiar University, Coimbatore <br>Accredited by NAAC With 'A' Grade
          <img style="margin-left: 10px;" class="logo1" src="New folder/3.png" alt="Logo">
        </label>
      </div>
      <ul>
        <li><a class="active" href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Feedback</a></li>
      </ul>
    </nav>
    <section></section>
  </body>
</html>
