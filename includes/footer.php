    <footer class="container mb-5">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <p class="footer-paragraph">FOOTER</p>
                        <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        <P>Powered by <a href="#">w3.css.</a> &copy; Copyright <?php echo date('Y'); ?> Designed By Justice. All right reserved</P>
                    </div>
                    <div class="col-xs-12 col-sm-4 footer-item">
                        <p class="footer-paragraph">BLOG POST</p>
                            <?php echo $str; ?> 
                    </div>
                    <div class="col-xs-12 col-sm-4 footer-item-2">
                        <p class="footer-paragraph">POPULAR TAGS</p>
                        <div class="my-tags">
                            <span class="text-white hover">Travel</span>
                            <?php foreach ($tags as $tag) : ?>
                                <span class="bg-dark text-white mr-1 active"><?php echo $tag ?></span>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>

            </footer>

            <div id="login" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="login-title">Login Now</h5>
                            <button class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="index.php">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input id="username" class="form-control" type="text" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" class="form-control" type="password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm-pass">Confirm Password</label>
                                    <input id="confirm-pass" class="form-control" type="password" name="confirm_pass">
                                </div>
                                <div class="form-group">
                                  <button type="submit"  class="btn btn-primary btn-block btn-lg"> Login</button>
                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            Not Registered ? <a href="register.php">Register Here</a>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>


    <script src="Assets/javascript/popper.js"></script>
    <script src="Assets/javascript/jquery.js"></script>
    <script src="Assets/javascript/bootstrap.min.js"></script>
    <script src="Assets/javascript/myscript.js"></script>
</body>

</html>