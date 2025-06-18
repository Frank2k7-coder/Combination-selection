<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Career Guidance - Combination Selection</title>
    
    <style>
      body {
        font-family: sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }

      header {
        overflow:hidden;
        background-color: #6435ca;
        color: white;
        padding: 1em 0;
        text-align: center;
      }

      nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
      }

      nav ul li {
        margin: 0 1em;
      }

      nav ul li a {
        color: white;
        text-decoration: none;
      }

      .hero-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding: 40px 20px;
        animation: fadeIn 1s ease-in;
      }

      .hero-section img {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        object-fit: cover;
        margin: 20px;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      }

      .hero-section img:hover {
        transform: scale(1.05) rotate(1deg);
      }

      .hero-text {
        max-width: 600px;
        animation: slideIn 1s ease-out;
      }

      .hero-text h2 {
        font-size: 28px;
        margin-bottom: 15px;
      }

      .hero-text p {
        font-size: 18px;
        line-height: 1.6;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }

      @keyframes slideIn {
        from {
          transform: translateX(50px);
          opacity: 0;
        }
        to {
          transform: translateX(0);
          opacity: 1;
        }
      }

      .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
        flex-grow: 1;
      }

      .information {
        background-color: orange;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        width: calc(50% - 30px);
        box-sizing: border-box;
      }

      .information h3 {
        color: #333;
        margin-top: 0;
        font-size: 30px;
      }

      .information h6 {
        color: #666;
        margin-bottom: 10px;
        font-size: 25px;
      }

      .information p {
        line-height: 1.6;
      }
     
      .container6{
        display: grid;
        grid-template-columns: repeat(5,auto);
        margin-top:100px;
        width:100%;
        justify-content:space-evenly;
        background-color:white;

      }
      .mine {

        width: 20px; 
        height: 20px; 
        background-color: black; 
        margin-left:800px;
        margin-top:50px;

      }
      .footer{
        margin-left:-10px;
      }

      .footer h5{
        font-size:15px;
        font-family:arial;
      }

      label{
        margin-left:40px;
        margin-bottom:50px;
      }
      .newsletter{
        margin-top:40px;
        width:80%;
        display:flex;
        margin-left:40px;
        justify-content:space-between;

      }


      .newsletter input{

        border:none;
        background-color:white;
        color: black;
        width:500px;
        border-bottom:1px solid;

      }

      button {

        width:100px;
        border: none;
        text-decoration:underline;
        background-color:white;
        color: black;


      }

      .country{
        width:200px;
        height:40px;
        margin-left:40px;
        margin-top:50px;

      }
      .lang{
        margin-top:50px;
        margin-left:40px;
        width:100px;
        height:40px;
      }


      .payment-icons {
        display: flex;
        gap: 10px; 
      }

      .payment-icons img {
        width: 30px; 
        height: 20px 
      }


      .terms a {
        text-decoration: none;
        color: black;
        font-size:15px;
        margin-right:10px;
      }
      .last{
        margin-bottom:50px;
      }


      footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 1em 0;
        margin-top: auto;
      }
     
      @media (max-width: 1000px) {
        .hero-section {
          flex-direction: column;
          text-align: center;
        }

        .hero-text {
          padding: 10px;
        }

        .information {
          width: 80%;
        }
      }
    </style>
  </head>
  <body>
    <header>
      <h1>Combination Selection</h1>
      <nav>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="admin-login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
          <li><a href="#" id="contact-btn">Contacts</a></li>
        </ul>
      </nav>
    </header>

    <section class="hero-section">
      <img
        src="https://media.istockphoto.com/id/1131216270/photo/descisions-ahead-road-sign-in-warning-yellow-with-blue-background-illustration.jpg?s=612x612&w=0&k=20&c=6P4YOz4z0tVHxV-cLoP1KGJE7M3VHhwGvrS7RkQaRMI="
        alt="Career Guidance"
      />
      <div class="hero-text">
        <h2>Empowering Your Career Journey</h2>
        <p>
          This website is designed to help students make wise academic choices
          through combination selection and career guidance. It motivates
          learners to work hard, focus on their passions, and build a future
          grounded in the right academic path. With inspiring content and
          guidance, you'll stay on track to achieve your dreams and unlock
          opportunities across science, business, and humanities.
        </p>
      </div>
    </section>

    <div class="container">
      <div class="information">
        <h3>MPC</h3>
        <h6>Mathematics, Physics, and Computer Science</h6>
        <p>
          Combining Mathematics, Physics, and Computer Science provides a strong
          foundation in analytical thinking and problem-solving. You'll develop
          versatile skills by understanding fundamental laws and computational
          methods, opening doors to diverse, in-demand careers like data
          science, software engineering, and research. This rigorous path
          requires mathematical aptitude, logical reasoning, and a dedication to
          continuous learning in a rapidly evolving technological landscape.
        </p>
      </div>
      <div class="information">
        <h3>PCB</h3>
        <h6>Physics, Chemistry, and Biology</h6>
        <p>
          This combination explores the natural world at its fundamental levels.
          Physics examines the laws governing matter and energy, biology
          investigates the intricacies of living organisms, and chemistry
          studies the composition, structure, properties, and reactions of
          matter. This blend develops strong analytical and investigative
          skills, attention to detail, and a systematic approach to
          understanding complex systems. It can lead to careers in research,
          medicine, pharmaceuticals, environmental science, biotechnology, and
          engineering.
        </p>
      </div>
      <div class="information">
        <h3>MCE</h3>
        <h6>Mathematics, Economy and Computer Science</h6>
        <p>
          This combination builds a powerful framework for understanding and
          shaping the modern world. Mathematics provides the analytical tools,
          economics offers insights into how societies allocate resources, and
          computer science equips you with the skills to process information and
          build technological solutions. This synergy fosters logical reasoning,
          problem-solving, data analysis, and computational thinking, paving the
          way for careers in finance, data science, business analytics, software
          development, economic consulting, and artificial intelligence.
        </p>
      </div>
      <div class="information">
        <h3>MEG</h3>
        <h6>Mathematics, Economy and Geography</h6>
        <p>
          This combination offers a unique lens on understanding spatial
          patterns and resource allocation. Mathematics provides the
          quantitative tools, economics analyzes human behavior in relation to
          resources, and geography examines the spatial distribution of
          phenomena and human-environment interactions. This blend cultivates
          analytical thinking, problem-solving, spatial reasoning, and an
          understanding of socio-economic dynamics, leading to careers in urban
          planning, market research, logistics, environmental economics,
          geographic information systems (GIS), and public policy.
        </p>
      </div>
      <div class="information">
        <h3>HGL</h3>
        <h6>History, Geography, and Literature</h6>
        <p>
          This combination delves into the human experience across time and
          space. History explores past events and their significance, geography
          examines the spatial distribution of phenomena, and literature offers
          insights into human emotions, experiences, and societal norms. This
          blend fosters critical thinking, strong communication skills, empathy,
          and an appreciation for diverse perspectives. It can lead to careers
          in education, journalism, writing, research, heritage management,
          international relations, and more.
        </p>
      </div>
    </div>


    <div class="container6">
      <div class="footer">
        <h5>About E-choice.</h5>
        <p>
         We are here to help you make the right choice in your academic journey
        </p>
        <p>We try our best to make you choice bright than before.</p>
        <p>
          It evolves. Clean and mature, that’s our way of life. It’s our code.
        </p>
        <p>Read more</p>
      </div>

      <div class="footer">
        <h5>Address</h5>
        <p>Kigali,RWANDA</p>
        <p>Eastern Province</p>
        <p>Rwamagana province</p>
        <p>Rubona Sector</p>
      </div>
      <div class="footer">
        <h5>Contact</h5>
        <p>Email us here</p>
        <p>frank@asyv.org</p>
      </div>
      <div class="footer">
        <h5>What we Do</h5>
        <p>Career Guidance</p>
        <p>Support </p>
        <p>Mthorship Program</p>
        <p>Choice Guidance</p>
        <p>Connection</p>
      </div>

      <div class="footer">
        <h5>Follow us</h5>
        <p>Instagram</p>
        <p>Facebook</p>
        <p>X</p>
        <p>WhatsApp</p>
      </div>
    </div>
    <label> Comments</label>
    <div class="newsletter">
      <div class="hello">
        <input type="text" name="username" required />
        <button type="submit">Submit</button>
      </div>
     
      <div class="terms">
        <a href="#">Terms & conditions</a>

        <a href="#">Privacy statement</a>
      </div>
    </div>
    <br /><br />
    <div class="last">
      <form class="newsletter-form">
        <select class="country" name="country" id="country">
          <option value="netherlands">Translate</option>
        </select>
        <select class="lang" name="language" id="language">
          <option value="english">English</option>
        </select>
      </form>
    </div>
    <footer>
      <p>&copy; ASYV Student Track. All rights reserved.</p>
    </footer>
  </body>
</html>
