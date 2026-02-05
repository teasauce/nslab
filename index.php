
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>UNM JTIK Lab Article Platform</title>

  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'?>

<div class="container">
  <div class="card">
    <h1><b>About</b></h1><p>
      The JTIK Lab Article Platform is a centralized academic portal designed to support the dissemination and management of scholarly works produced by lecturers and researchers within the JTIK laboratory environment. This platform serves as a digital repository that enables users to explore academic profiles, access published articles, and stay informed about ongoing research activities.
      Developed with a focus on accessibility and clarity, the platform provides a structured overview of academic contributions across various fields, encouraging knowledge sharing and interdisciplinary collaboration. Each lecturer is given a dedicated profile page where their publications and research interests can be presented in an organized and user-friendly manner.
      In response to the growing demand for digital academic resources, the JTIK Lab Article Platform aims to bridge the gap between research production and public access. By leveraging modern web technologies, the platform is designed to be scalable, maintainable, and adaptable to future backend integrations, including database-driven content management and advanced browsing features.
      Ultimately, this platform reflects JTIK's commitment to fostering academic excellence, transparency, and innovation in research dissemination, while supporting students, educators, and researchers in navigating an increasingly digital academic landscape.
    </p>
  </div>
  <div class="card">
    <h1><b> List of professors </b> </h1>
    <p> Afterwards, you're supposed to include in a professor's name and make it a hyperlink to their 
    dedicated subpage where you can then browse their published articles. For now there's only 2 professors simply due to the fact that we don't know who else to add here. e.g.,: </p>
    <div class="professor-list">
      <a href="dosen/jumadi/" class="professor-box">
        <img src="assets/images/jumadi.jpg" alt="Photo of Dr. Jumadi">
          <span>Dr. Jumadi M. Parenreng, S.Pd., M.Pd.</span>
      </a>

      <a href="dosen/abcd/" class="professor-box">
        <img src="assets/images/default.jpg" alt="Photo of Dr. ABCD">
        <span>Dr. ABCD, S.Kom., M.Kom.</span>
      </a>
    </div>
  </div>
</div>

<?php include 'footer.php'?>

</body>
</html>
