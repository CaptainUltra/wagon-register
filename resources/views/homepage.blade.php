@extends('layouts.app')

@section('content')
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="carousel-img" src="/storage/homepage-images/default-slide1.jpg" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>50 52 22-97 009-5</h1>
            <p>В състава на влак №8601 „Слънчев бряг“, гара Пловдив</p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="carousel-img" src="/storage/homepage-images/default-slide2.jpg" alt="Second slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>61 52 85-97 001-3</h1>
            <p>В състава на влак №8601 „Слънчев бряг“, гара Пловдив</p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="carousel-img" src="/storage/homepage-images/default-slide3.jpg" alt="Third slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>50 52 22-97 007-9</h1>
            <p>В състава на влак №8601 „Слънчев бряг“, гара Пловдив</p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <!-- What site offers section -->
  <div class="container-fluid padding" id="whatOffersSection">
    <div class="row welcome text-center">
      <div class="col-12">
          <h1 class="display-4">Какво предлага сайтът?</h1>
      </div>
      <hr>
      <div class="col-12">
        <p class="lead">За граждани, служители и любители - за всеки по нещо</p>
      </div>
    </div>
  </div>
  <div class="container-fluid padding">
    <div class="row text-center padding">
      <div class="col-xs-12 col-sm-6 col-md-4">
          <img class="rounded-circle how-to-img" src="/storage/homepage-images/drawings/undraw_to_do_list_a49b.svg">
          <h2>Влакови композиции</h2>
          <p>Ще пътувате с влак? Или просто се интересувате? Разберете с какви вагони се движи влакът, с който ще пътувате! Разгледайте и отвън, и от вътре!</p>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
          <img class="rounded-circle how-to-img" src="/storage/homepage-images/drawings/undraw_web_developer_p3e5.svg">
          <h2>Информация за вагони</h2>
          <p>Служител сте в железницата и Ви трябва информация за даден вагон? Тук я има - брой места, спирачна маса и пр.</p>
      </div>
      <div class="col-sm-12 col-md-4">
          <img class="rounded-circle how-to-img" src="/storage/homepage-images/drawings/method-draw-image.svg">
          <h2>Статистика за вагоните</h2>
          <p>Ако вашето хоби са влаковете и искате да разберете кой вагон къде е бил, то в сайта ни тази инфомация е налична.</p>
      </div>	
    </div>
    <hr class="my-4">
  </div>

  <!-- About -->
  <div class="container-fluid padding" id="about">
    <div class="row padding">
      <div class="col-md-12 col-lg-6">
        <h2>За сайта...</h2>
        <p class="text-justify">Всеки от нас има предпочитания за заобикалящия го свят. Едни харесват зелен цвят, други червен. Е, хората забелязват какво им харесва докато пътуват с влак и какво не.
        Купеен, безкупеен, първа-втора класа, мотриса или не - всичко това можете да разберете от нашия сайт.
        Когато сте решили да пътувате на някъде и сте видели разписанието, може да разберете в какво ще пътувате.
        Ако можете да избирате, направете го! Пътувайте във влака, в който ще ви бъде най-приятно!</p>
        <p>Ако пък сте служител в железницата, то тук можете да намерите информация, която би Ви била полезна.
        Дали вагонът е минал ремонт, за каква скорост е, как изглежда интериорно...
        Ще знаете дори за проблемите (ако има такива) на даденият вагон, за да сте напълно подготвени за работният си ден.</p>
        <p>За най-заинтересованите приложението предлага подробна статистика за вагонния парк на родната железница, включващ историческа хронология на събитията, свързани с даден вагон. 
        Предоставена е и възможността да се правят различни сводки на базата на информацията, налична в сайта.</p>

      </div>
      <div class="col-md-12 col-lg-6">
        <img class="img-fluid" src="/storage/homepage-images/drawings/undraw_experts3_3njd.svg">
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="footer mt-auto py-3">
      <div class="container text-center">
        <span class="">Stoyan Haydushki</span>
      </div>
  </footer>
@endsection