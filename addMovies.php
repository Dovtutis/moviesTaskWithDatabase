<?php
require "./Class/DB.php";
require "./inc/head.php";
?>

    <div class="container d-flex justify-content-center">
        <div class="col-sm-6">
            <h1 class="text-center">Add movie</h1>
            <form action="addMovies.php" method="post" autocomplete="off" id="addMovieForm">
                <div class="form-group">
                    <label for="image">Image url</label>
                    <input type="text" name="image" class="form-control" value="" id="image">
                </div>
                <div class="form-group">
                    <label for="title">Movie title</label>
                    <input type="text" name="title" class="form-control" value="" id="title">
                </div>
                <div class="form-group">
                    <label for="year">Movie year</label>
                    <input type="text" name="year" class="form-control" value="" id="year">
                </div>
                <div class="form-group">
                    <label for="genre">Movie genre:</label>
                    <br>
                    <input type="radio" id="fantasy" name="genre" value="fantasy" class="">
                    <label for="fantasy" class="">Fantasy</label><br>
                    <input type="radio" id="drama" name="genre" value="drama" class="">
                    <label for="drama">Drama</label><br>
                    <input type="radio" id="comedy" name="genre" value="comedy" class="">
                    <label for="comedy">Comedy</label><br>
                    <input type="radio" id="action" name="genre" value="action" class="">
                    <label for="action">Action</label><br>
                    <input class="btn btn-primary d-block" type="submit" name="submit" value="Add movie">
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
        const movieFormData = new FormData(addMovieForm);
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
            }).catch(error => console.error(error.message));

        function displayErrorsJs(errors){
            if (errors.title){
                outputJsErrorField('title');
            } else {
                dissableJsErrorField('title');
            }

            if (errors.image){
                outputJsErrorField('image');
            }else {
                dissableJsErrorField('image');
            }

            if (errors.year){
                outputJsErrorField('year');
            }else {
                dissableJsErrorField('year');
            }
        }

        function outputJsErrorField(field){
            const fieldEl = document.getElementById(field);
            fieldEl.classList.add('error-input');
        }

        function dissableJsErrorField(field){
            const fieldEl = document.getElementById(field);
            fieldEl.classList.remove('error-input');
        }
    }
</script>