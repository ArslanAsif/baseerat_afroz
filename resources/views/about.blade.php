@extends('layouts.app')

@section('content')
    <section id="main" class="about-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                        <div class="col-md-9 entry-page">
                            <h2 class="title">About Us</h2>
                            <?php echo $about->descr_eng;?>
                        </div><!-- /.content-right -->
                        <div class="col-md-3">
                            <div class="about-contact">
                                <h3 class="title" style="margin-top: -10px">Contact us</h3>
                                <br>
                                <?php echo $contact->descr_eng;?>
                            </div>
                            <div>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3400.0656615829826!2d74.31608831501543!3d31.549812552844656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391904af45e05fb9%3A0xd147684a19c4ffa0!2sRahimia+Institute+of+Quranic+Sciences+(Trust)+Lahore!5e0!3m2!1sen!2s!4v1497256500586" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div><!-- /.content-left -->
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section>
@endsection