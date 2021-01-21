<?php
require "./Class/DB.php";
require "./inc/head.php";

$db = new DB();

$currentPage = 'addMovie';
$currentPageTitle = 'Add New Movie';
$submitBtnName = 'submit';
$genre = '';

if (isset($_GET['edit'])){
    $currentPageTitle = 'Edit Movie';
    $submitBtnName = 'edit';
    $idFromGet = htmlspecialchars($_GET['id']);
    $post = $db->getMovie($idFromGet);
    $image = $post['img'];
    $title = $post['title'];
    $year = $post['year'];
    $genre = $post['genre'];
    $id = $post['id'];
}
?>

    <div class="container d-flex justify-content-center">
        <div class="col-sm-6">
            <h1 class="text-center"><?php echo $currentPageTitle?></h1>
            <form action="addMovies.php" method="post" autocomplete="off" id="addMovieForm">
                <div class="form-group">
                    <label for="image">Image url</label>
                    <input type="text" name="image" class="form-control" value="<?php echo $image ?? ''?>" id="image">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="title">Movie title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $title ?? ''?>" id="title">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="year">Movie year</label>
                    <input type="text" name="year" class="form-control" value="<?php echo $year ?? ''?>" id="year">
                    <small class="error-message"></small>
                </div>
                <div class="form-group">
                    <label for="genre">Movie genre:</label>
                    <br>
                    <input type="radio" id="fantasy" name="genre" value="fantasy" class="" <?php echo $genre === 'fantasy' ? 'checked' : null; ?>>
                    <label for="fantasy" class="">Fantasy</label><br>
                    <input type="radio" id="drama" name="genre" value="drama" class="" <?php echo $genre === 'drama' ? 'checked' : null; ?>>
                    <label for="drama">Drama</label><br>
                    <input type="radio" id="comedy" name="genre" value="comedy" class="" <?php echo $genre === 'comedy' ? 'checked' : null; ?>>
                    <label for="comedy">Comedy</label><br>
                    <input type="radio" id="action" name="genre" value="action" class="" <?php echo $genre === 'action' ? 'checked' : null; ?>>
                    <label for="action">Action</label><br>
                    <input class="btn btn-primary d-block" type="submit" name="<?php echo $submitBtnName?>" value="<?php echo $currentPageTitle?>">
                </div>
            </form>
        </div>
    </div>


<?php
require "./inc/footer.php";
?>

<script>
    const addMovieForm = document.getElementById('addMovieForm');
    const addMoviePageBtn = document.getElementById('add-movie');
    const loadMoviesBtn = document.getElementById('load-movies');

    addMovieForm.addEventListener('submit', (event)=>{
        event.preventDefault();
        clearErrors();
        const movieFormData = new FormData(addMovieForm);
        movieFormData.append('btnName', '<?php echo $submitBtnName?>');
        movieFormData.append('id', '<?php echo $id ?? '';?>');
        addMovieFetch(movieFormData);
    })

    addMoviePageBtn.addEventListener('click', ()=>{
        location.replace("./addMovies.php");
    })

    loadMoviesBtn.addEventListener('click', ()=>{
        location.replace("./index.php");
    })

    function addMovieFetch(data) {
        const options = {
            method: 'post',
            body: data
        }
        fetch('./process/addMovieProcess.php', options)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.errors){
                    displayErrorsJs(data.errors);
                }
                if (data === 'Movie added successfully' || data === 'Movie edited successfully'){
                    location.replace("./index.php");
                }
            }).catch(error => console.error(error.message));

        function displayErrorsJs(errors){
            const entries = Object.entries(errors);
            entries.map(entry => outputJsErrorField(entry[0], entry[1]));
        }

        function outputJsErrorField(field, msg){
            const fieldEl = document.getElementById(field);
            fieldEl.classList.add('error-input');
            fieldEl.nextElementSibling.innerHTML = msg;
        }
    }

    function clearErrors() {
        const foundErrors = document.querySelectorAll('.error-input');
        if (foundErrors){
            foundErrors.forEach(errorElement => errorElement.classList.remove('error-input'))
        }
        clearErrorMessages();
    }

    function clearErrorMessages (){
        const errorsParagraphs = document.querySelectorAll('.error-message');
        if (errorsParagraphs){
            errorsParagraphs.forEach(errorElement => errorElement.innerHTML = '');
        }
    }

</script>