@extends('layouts.user-dashboard')
@section('title', 'dashboard')
@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CardWise AI – Smart Card Finder</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://cdn.tailwindcss.com"></script>

<style>
.tile { transition: all .25s ease; }
.tile:hover { transform: translateY(-4px); box-shadow:0 15px 35px rgba(0,0,0,0.08); }
</style>
</head>

<body class="bg-gray-50 text-gray-800">

<!-- HEADER -->
<div class="bg-white border-b px-12 py-6 flex justify-between items-center">
  <h1 class="text-2xl font-semibold text-indigo-700">💳 CardWise AI</h1>
  <span class="text-gray-500">Purpose-Based Card Recommendation Platform</span>
</div>

<!-- HERO -->
<section class="px-12 py-20 bg-gradient-to-r from-indigo-50 to-blue-50">
  <h2 class="text-4xl font-bold max-w-3xl">Find the Best Credit & Debit Card for Every Type of Spending</h2>
  <p class="mt-4 text-lg text-gray-600 max-w-2xl">
    CardWise AI helps users choose the right card for lounge access, shopping, travel, dining and more – instantly and intelligently.
  </p>
</section>

<!-- PURPOSE SECTION -->
<section class="px-12 py-16 bg-white">
<h3 class="text-2xl font-semibold mb-8">Choose Your Spending Purpose</h3>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

<div onclick="select('Lounge Access','Axis Magnus, HDFC Infinia','Unlimited airport lounges & premium travel services')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Lounge Access</h4>
<p class="text-gray-500 mt-1">Airport comfort</p>
</div>

<div onclick="select('Electricity Bill','Amazon Pay ICICI','5% cashback on electricity and utility bills')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Electricity Bill</h4>
<p class="text-gray-500 mt-1">Monthly savings</p>
</div>

<div onclick="select('Online Shopping','Flipkart Axis, SBI Cashback','Instant discounts on e-commerce')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Online Shopping</h4>
<p class="text-gray-500 mt-1">Digital deals</p>
</div>

<div onclick="select('Offline Shopping','HDFC Millennia','POS rewards and retail offers')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Offline Shopping</h4>
<p class="text-gray-500 mt-1">Store rewards</p>
</div>

<div onclick="select('Traveling','Amex Platinum, Axis Atlas','Miles, insurance & hotel privileges')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Traveling</h4>
<p class="text-gray-500 mt-1">Luxury travel</p>
</div>

<div onclick="select('Movie Tickets','RBL Play, SBI Elite','Buy 1 Get 1 movie tickets')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Movie Tickets</h4>
<p class="text-gray-500 mt-1">Entertainment offers</p>
</div>

<div onclick="select('Dinner','EazyDiner IndusInd','Up to 40% off at restaurants')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Dinner</h4>
<p class="text-gray-500 mt-1">Dining privileges</p>
</div>

<div onclick="select('Hotels & Restaurants','Axis Reserve, Amex Platinum','Luxury stays & fine dining')"
class="bg-gray-50 rounded-xl border p-6 tile cursor-pointer">
<h4 class="font-semibold text-lg">Hotels & Restaurants</h4>
<p class="text-gray-500 mt-1">Hospitality excellence</p>
</div>

</div>
</section>

<!-- RECOMMENDATION -->
<section class="px-12 py-16 bg-indigo-50">
<div id="panel" class="hidden max-w-4xl bg-white rounded-xl shadow p-10">
  <h3 id="title" class="text-2xl font-semibold text-indigo-700"></h3>
  <p class="mt-4"><strong>Best Cards:</strong> <span id="cards"></span></p>
  <p class="mt-2"><strong>Why Best:</strong> <span id="desc"></span></p>
</div>
</section>

<!-- FEATURES -->
<section class="px-12 py-20 bg-white">
<h3 class="text-2xl font-semibold mb-10">Why CardWise AI?</h3>
<div class="grid md:grid-cols-3 gap-10">
  <div>
    <h4 class="font-semibold">Purpose-Based Matching</h4>
    <p class="text-gray-500 mt-2">Users get card suggestions based on actual spending needs.</p>
  </div>
  <div>
    <h4 class="font-semibold">No Confusing Comparison</h4>
    <p class="text-gray-500 mt-2">Simple & direct recommendations instead of overwhelming lists.</p>
  </div>
  <div>
    <h4 class="font-semibold">Fintech-Grade Accuracy</h4>
    <p class="text-gray-500 mt-2">Carefully curated card benefits from real market data.</p>
  </div>
</div>
</section>

<!-- TRUST -->
<section class="px-12 py-20 bg-gray-100">
<h3 class="text-2xl font-semibold mb-6">Trusted by Users</h3>
<p class="max-w-2xl text-gray-600">
Helping thousands of users save money, enjoy premium benefits and choose smarter financial products.
</p>
</section>

<!-- CTA -->
<section class="px-12 py-20 bg-indigo-600 text-white">
<h3 class="text-3xl font-bold">Start Finding Your Perfect Card Today</h3>
<p class="mt-4 text-lg">Let CardWise AI guide you to smarter spending.</p>
<button class="mt-6 bg-white text-indigo-700 px-6 py-3 rounded-lg font-semibold">
Get Started
</button>
</section>

<script>
function select(title,cards,desc){
  document.getElementById('panel').classList.remove('hidden');
  document.getElementById('title').innerText = title;
  document.getElementById('cards').innerText = cards;
  document.getElementById('desc').innerText = desc;
  window.scrollTo({ top: document.getElementById('panel').offsetTop - 100, behavior: 'smooth' });
}
</script>

</body>
</html>





@endsection
