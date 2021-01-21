<?php
require "./Class/DB.php";
require "./inc/head.php";
?>

<main id="main"></main>

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
        movieContainer.innerHTML = '';
        respData.map(item =>{
            movieContainer.innerHTML +=
                `
            <div class="movie">
                <img src="${item['img']}" alt="${item['title']}?>">
                <div class="movie-info">
                    <div>
                        <div>
                            <h5>${item['title']} </h5>
                        </div>
                        <div class="editDeleteBar">
                            <div><i class="fas fa-trash-alt deleteMovieBtn" id="${item['id']}"></i></div>
                            <a href="addMovies.php?edit=1&id=${item['id']}" class="d-block"><i class="fas fa-edit"></i></a>
                        </div>
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
        const deleteButton = document.querySelectorAll('.deleteMovieBtn').forEach(item=> {
            item.addEventListener('click', deleteMovieFetch);
        });
    }

    async function deleteMovieFetch (event) {
        let id = event.target.id;
        const options = {
            method: 'GET',
        }
        await fetch(`./process/deleteMovieProcess.php?id=${id}`, options)
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data === 'Movie deleted successfully'){
                    location.replace("./index.php");
                }
            }).catch(error => console.error(error.message));
    }

</script>
