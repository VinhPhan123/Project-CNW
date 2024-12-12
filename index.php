
<?php 
	include './layouts/header.php';
?>

<div style="display: flex; justify-content: center;">

<?php 
    if(isset($_SESSION['role'])) {
		include './layouts/menu.php';
	}

?>

<style>
	
    body {
        padding: 0;
        margin: 0;
        font-family: 'Segoe UI', 'Roboto', 'Oxygen',
        'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue',
        sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    @media (min-width: 1350){
        .container, .container-lg, .container-md, .container-sm, .container-xl {
            max-width: 1300px !important;
        }
    }

    .btn-login {
        border-radius: 5px;
        margin-right: 15px;
        padding: 0 15px;
        border: 1px solid #535353;
        height: 40px;
        }

        .btn-signup {
        border-radius: 5px;
        height: 40px;
        padding: 0 15px;
        background-color: #303030;
        color: white;
        border: 1px solid #292929;
        }

    .btn-signup:hover {
        background-color: black;
    }

    .navbar {
        padding-top: 20px;
        z-index: 0;
        background-color: rgb(0, 0, 0, 0) !important;   
    }

    .active { 
    color: #00bfff;
    }

    .homepage-content {
        padding: 100px;
        position: relative;
        width: 50%;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .title-1 {
            font-size: 40px;
            font-weight: 600;
        }

        .title-2 {
            font-size: 22px;
        }

    .title-3 button {
        border-radius: 5px;
        height: 40px;
        padding: 0 15px;
        background-color: #303030;
        color: white;
    }

    .title-3 button:hover{
        background-color: black;

    }

    video {
    position: fixed;
    bottom: 0;
    width: 100vw;
    }
</style>



<link rel="stylesheet" href="./assets/css/index.css">

<div style="display: block; width: 100%;" class="app-container">
    <div class="homepage-container">
        <video autoplay muted loop>
            <source src='./assets/video/video-homepage.mp4'
            type='video/mp4' />
        </video>

        <div class='homepage-content'>
            <div class='title-1'>There's a better way to ask</div>
            <div class='title-2'>
            Welcome to Bla, a reliable online platform that helps candidates easily register and check 
            the results of the high school transcript-based admission process to universities and colleges nationwide.
            </div>
            <div class='title-3'>
                <button>Get's started. It's free</button>
            </div>
        </div>
    </div>

	<?php 
		include './layouts/footer.php';
	?>
</div>