<?php
require "./Class/DB.php";
require "./inc/head.php";
?>

<main id="main">

</main>

<?php
require "./inc/footer.php";
?>

<script>

    const loadMoviesBtn = document.getElementById('load-movies');
    const addMoviePageBtn = document.getElementById('add-movie');
    const movieContainer = document.getElementById('main');

    loadMoviesBtn.addEventListener('click', ()=>{
        loadMoviesFetch();
    })

    addMoviePageBtn.addEventListener('click', ()=>{
        location.replace("./addMovies.php");
    })
    loadMoviesFetch ();

    async function loadMoviesFetch (){
        const resp = await fetch('./process/loadMoviesProcess.php',{
            method: 'GET'
        });
        const respData = await resp.json();

        respData.map(item =>{
            movieContainer.innerHTML +=
                `
            <div class="movie">
                <img src="${item['img']}" alt="${item['title']}?>">
                <div class="movie-info">
                    <div>
                        <h5>${item['title']}</h5>
                    </div>
                    <div>
                        <h6>${item['year']}</h6>
                    </div>
                    <div>
                        <h6>${item['genre']}</h6>
                    </div>
                </div>
            </div>
            `
        })
    }

</script>
