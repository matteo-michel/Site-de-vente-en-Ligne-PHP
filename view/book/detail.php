<?php
echo '
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25">    
                                <img src="data:image/jpeg;base64,' . base64_encode($book->get('image')) . '" alt="book-image"/>
                                </div>
                                <h6 class="f-w-600">' . $book->get('titre') . '</h6>
                                <p>' . $book->get('isbn') . '</p>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informations</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Resumé</p>
                                        <h6 class="text-muted f-w-400">' . $book->get('resume') . '</h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Modifications</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a class="btn btn-warning" role="button" href="index.php?controller=book&action=update&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="fas fa-pen"></i> Modifier le livre</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="btn btn-danger" role="button" href="index.php?controller=book&action=delete&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="fas fa-times"></i> Supprimer le livre</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
?>

