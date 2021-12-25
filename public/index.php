<?php include("../db.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.15.1/dist/katex.min.css" integrity="sha384-R4558gYOUz8mP9YWpZJjofhk+zx0AS11p36HnD2ZKj/6JR5z27gSSULCNHIRReVs" crossorigin="anonymous">

    <!-- The loading of KaTeX is deferred to speed up page rendering -->
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.15.1/dist/katex.min.js" integrity="sha384-z1fJDqw8ZApjGO3/unPWUPsIymfsJmyrDVWC8Tv/a1HeOtGmkwNd/7xUS0Xcnvsx" crossorigin="anonymous"></script>

    <!-- To automatically render math in text elements, include the auto-render extension: -->
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.15.1/dist/contrib/auto-render.min.js" integrity="sha384-+XBljXPPiv+OzfbB3cVmLHf4hdUFHlWNZN5spNQ7rmHTXpd7WvJum6fIACpNNfIR" crossorigin="anonymous"
        onload="renderMathInElement(document.getElementById('content'));"></script>
</head>
<body>
    <header>
        <div class="container-header">
            <button class="box b1">
                <div class="container-lines">
                    <div class="lines"></div>
                    <div class="lines"></div>
                    <div class="lines"></div>
                </div>
            </button>
            <div id="container-swapper">
                <button class="theme-toggle-button">
                    <script>
                        // The script is here, so it loads quicker. 
                        // On load, gets the theme if there's one.
                        const theme = localStorage.getItem("theme");
                        const themeToggleBtn = document.querySelector(".theme-toggle-button");

                        // If the value is light, change the theme to light
                        if (theme === "light") {
                        document.body.classList.add("light");
                        }

                        // Switch between ligt and dark, and set the value to local storage.
                        themeToggleBtn.onclick = (e) => {
                        document.body.classList.toggle("light");
                        if (document.body.classList.contains("light")) {
                            localStorage.setItem("theme", "light");
                        } else localStorage.setItem("theme", "dark");
                        };
                    </script>
                    <!-- Swapper -->
                    <svg class="icon" style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M7.5,2C5.71,3.15 4.5,5.18 4.5,7.5C4.5,9.82 5.71,11.85 7.53,13C4.46,13 2,10.54 2,7.5A5.5,5.5 0 0,1 7.5,2M19.07,3.5L20.5,4.93L4.93,20.5L3.5,19.07L19.07,3.5M12.89,5.93L11.41,5L9.97,6L10.39,4.3L9,3.24L10.75,3.12L11.33,1.47L12,3.1L13.73,3.13L12.38,4.26L12.89,5.93M9.59,9.54L8.43,8.81L7.31,9.59L7.65,8.27L6.56,7.44L7.92,7.35L8.37,6.06L8.88,7.33L10.24,7.36L9.19,8.23L9.59,9.54M19,13.5A5.5,5.5 0 0,1 13.5,19C12.28,19 11.15,18.6 10.24,17.93L17.93,10.24C18.6,11.15 19,12.28 19,13.5M14.6,20.08L17.37,18.93L17.13,22.28L14.6,20.08M18.93,17.38L20.08,14.61L22.28,17.15L18.93,17.38M20.08,12.42L18.94,9.64L22.28,9.88L20.08,12.42M9.63,18.93L12.4,20.08L9.87,22.27L9.63,18.93Z" />
                    </svg>
                    <p>Swap Themes</p>
                </button>
            </div>
        </div>
    </header>
    <main>
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-scrollbox">
            <?php
                $sql = 
                'SELECT * FROM chapters ORDER BY chapters_number ASC';
                $datas = $db->query($sql);
                $a = $datas->fetchAll();

                echo '<h3 id="title-infos"> Voici la liste des chapitres associés à leurs numéros </h3>';  //POUR CEDRIC SI TU VOIS A ME DIRE SI TU VEUX QUE L ON PRECISE OU NON CAR CA PEUT SUREMENT PARAITRE BISARD A COUP D OEIL
                echo '<br/><hr/><br/>';
                foreach ($a as $ch) {
                    $id = $ch['chapters_id'];
                    $sql = "SELECT * FROM examples WHERE examples_chapter_id=$id ORDER BY examples_number ASC";
                    $datas = $db->query($sql);
                        
                    echo '<summary><strong id="bold">' . $ch['chapters_number'] . '</strong>. ' . $ch['chapters_title'] . '</summary>';

                    while ($row=$datas->fetch()) {

                        $type_bac = $row['examples_is_bac'] == 1 ? '<span class="type-bac">BAC</span>' : "";
                        $href = '?t=' . $ch['chapters_id'] . '-' . $row['examples_number'];
                        echo '<ol class="chapters">
                                <li class="chapters-examples">
                                    <a id="examples" href="' . $href . '"> 
                                    <div id="examples-wrapper">
                                        <strong id="bold">' . $ch['chapters_number'] . '.' . $row['examples_number'] . '.</strong>
                                        Exemple ' . $row['examples_number'] . $type_bac . '
                                    </div></a>
                                </li>
                            </ol>';
                            // End of li for numbers and examples
                                    
                    }

                    echo "</details>";
                }

            ?>
        </div>
        <!-- End/sidebar-scrollbox  -->
    </nav>
    <!-- End/sidebar -->
    <section id="content">
        <?php

            // Check if the arguement t is set in the url
            // if not send error.html
            if (isset($_GET['t'])) {

                $t = $_GET['t'];
                // Destructure the value of t
                list($chapter_id, $examples_number) = explode("-", $t);
                
                // if they are empty send error.html 
                if (!(empty($chapter_id) or empty($examples_number))) {
                    // Query the correct example based on the example number and its chapter
                    $sql = "SELECT * FROM chapters JOIN examples ON chapters_id=examples_chapter_id WHERE examples_number=$examples_number AND chapters_id=$chapter_id";
                    
                    $datas = $db->query($sql);
                    $row = $datas->fetch();
                    
                    // Get the path of the html corresponding to the example
                    
                    // If the example exists, include its html
                    // else include the error page.
                    if (!empty($row)) {
                        $path = $row["examples_path"];
                        include($path);
                    } else {
                        include("./error.html");
                    }
                    
                } else include "./error.html" ;
            } else include "./error.html";

        ?>

    </section>
    <!-- End/content -->
    </main>
</body>
<script>
    const hiddenItems = document.getElementsByClassName("hidden");

    for (let x = 0; x < hiddenItems.length; x++) {
    const hi = hiddenItems[x];
    hi.style.visibility = "hidden";

    const parent = hi.parentNode;

    const button = document.createElement("span");
    button.className = "material-icons";
    button.id = "eye";
    button.textContent = "visibility_off";
    button.title = "Montrer la réponse.";
    button.onclick = () => {
        hi.style.visibility = hi.style.visibility === "hidden" ? "" : "hidden";
        button.textContent =
        hi.style.visibility === "hidden" ? "visibility_off" : "visibility";
    };

    const wrapper = document.createElement("section");
    wrapper.className = "wrapper-hidden";
    parent.replaceChild(wrapper, hi);
    wrapper.appendChild(hi);

    wrapper.appendChild(button);
    }

    console.log(hiddenItems);

    // Responsive & humburger

    const allBoxes = document.querySelectorAll(".box");
    const sidebar = document.getElementById("sidebar");

    allBoxes.forEach((box) => {
    box.onclick = (e) => {
        e.target.classList.toggle("active");
        sidebar.style.display = e.target.classList.contains("active")
        ? "flex"
        : "none";

        sidebar.classList.toggle("active");
    };
    });

    window.onresize = (e) => {
    const w = window.matchMedia("(max-width: 896px)");
    if (!w.matches) {
        sidebar.classList.add("active");
        sidebar.style.display = "flex";
        allBoxes.forEach(box => box.classList.add("active"))
    } else {
        sidebar.classList.remove("active");
        sidebar.style.display = "none";
        allBoxes.forEach(box => box.classList.remove("active"))
    }
    };
</script>
</html>