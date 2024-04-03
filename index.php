<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP and MySQL Upload Image</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <style>
        .image-preview {
            background-image: url('avatar.png');
            width: 14%;
            height: 100px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
        }

        .photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <?php
    include "dbcon.php";
    $sql = "select * from users order by name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    include "upload.php";
    ?>
    <div class="container">
        <h1 class="mb-5">PHP and MySQL Upload Image</h1>
        <div class="table-responsive">
            <h2>List of users</h2>
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#modalAddnew">Add New</a>

            <table class="mt-5 table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $counter = 0;
                        foreach ($result as $row) {
                            $counter++;
                    ?>
                            <tr class="">
                                <td scope="row"><?= $counter ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><img class="photo" src="uploads/<?= $row['photo'] ?>"></td>
                                <td>
                                    <a href="index.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete the user?')">
                                        <button type="button" class="btn btn-danger" title="delete the user">
                                            Delete
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td>No users to display</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAddnew" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Add New
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Enter a Name" />
                            <div class="text-danger"><?= $name_err ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Select A Photo</label>
                            <input type="file" class="form-control" name="photo" id="photo" placeholder="" aria-describedby="fileHelpId" onchange="previewImg(this)" />
                            <div id="fileHelpId" class="form-text">Allowed file types: jpg, jpeg, png</div>
                            <div class="text-danger"><?= $photo_err ?></div>
                        </div>
                        <div class="mb-5 image-preview"></div>
                        <button type="submit" name="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </form>
                    <div class="text-danger"><?= $err_msg ?></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImg(input) {
            if (input.files && input.files[0] != "") {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".image-preview").css('background-image', 'url(' + e.target.result + ')');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>