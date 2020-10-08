<header class="masthead" style="background-image: url('/public/images/any-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                <img class="imgPosts" src="/public/materials/<?php echo $data['id']; ?>.jpg" class="mr-3" alt="...">
                    <h1><?php echo htmlspecialchars($data['name'], ENT_QUOTES); ?></h1>
                    <span class="subheading"><?php echo htmlspecialchars($data['description'], ENT_QUOTES); ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <p><?php echo htmlspecialchars($data['text'], ENT_QUOTES); ?></p>
        </div>
    </div>
</div>