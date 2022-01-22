<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Laptop Detail</title>
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
   <div class="container col-md-6 mt-4 text-center">
      <div class="row mb-2">
         <div class="col">
            <img src="<?= $laptop->image ?>" width="300" height="300">
         </div>
         <div class="col">
            <h2 class="text text-success"><?= $laptop->name ?> </h2>
            <h3>Brand: <?= $laptop->brand ?> </h3>
            <h3>Price: <?= $laptop->price ?> USD </h3>
            <h3>Color: <?= $laptop->color ?> </h3>
            <h3>Year: <?= $laptop->year ?> </h3>
         </div>
      </div>
      <a href="index.php">
         <img src="https://www.icebergwebdesign.com/wp-content/uploads/2015/11/back-blue-button-xs.jpg" 
         width="100" height="100">
      </a>
   </div>
</body>
</html>