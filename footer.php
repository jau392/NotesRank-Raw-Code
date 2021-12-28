</div>
    </main>
    <footer class="bg-dark text-light">
         <div class="container py-5">
            <div class="row align-items-center">
                <div class="col text-center">
                    &copy; Jeremy Ulfohn and Syed Raza, 2021.
               </div>
            </div>
         </div>
      </footer>
      <audio autoplay><source src="background.mp3" type="audio/mpeg">Your browser does not support html5 audio.</audio>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="customjs.js"></script>
    <script>
    <?php
        if(count($errorMessages) > 0)
        {
            foreach($errorMessages as $emesg)
            {
                echo '$("#alertSection").append(\'<div class="alert alert-danger alert-dismissible" role="alert">'.$emesg.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>\')';
            }
        }
        if(count($successMessages) > 0)
        {
            foreach($errorMessages as $smesg)
            {
                echo '$("#alertSection").append(\'<div class="alert alert-success alert-dismissible" role="alert">'.$smesg.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>\')';
            }
        }
        if($processCards != "")
        {
            echo 'processCards("'.$processCards.'")';
        }
    ?>
    </script>
  </body>
</html>