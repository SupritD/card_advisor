@extends('layouts.user-dashboard')
@section('title', 'dashboard')
@section('content')

<style>
body {
    background: #f9fafb;
    font-family: 'Inter', system-ui, sans-serif;
    color: #1f2937;
}

.pro-dashboard {
    max-width: 1300px;
    margin: auto;
    padding: 40px 30px;
}

.pro-section {
    margin-bottom: 55px;
}

.pro-heading {
    font-size: 1.3rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 18px;
    position: relative;
    padding-left: 12px;
}

/* .pro-heading::before {
    content: "";
    position: absolute;
    left: 0;
    top: 3px;
    height: 75%;
    width: 4px;
    background: linear-gradient(to bottom, #4f46e5, #22c55e);
    border-radius: 6px;
} */

/* Card Row */
.pro-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

/* Cards */
.pro-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 20px;
    height: 130px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    font-size: 0.95rem;
    font-weight: 600;
    display: flex;
    align-items: flex-end;
    transition: all 0.25s ease;
    cursor: pointer;
}

.pro-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}

.pro-card.selected {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
}

</style>

<div class="pro-dashboard">

  <div class="pro-section">
    <h3 class="pro-heading">Lounge Access</h3>
    <div class="pro-row">
      <div class="pro-card">Platinum Lounge</div>
      <div class="pro-card">Elite Travel</div>
      <div class="pro-card">Priority Pass</div>
    </div>
  </div>

  <div class="pro-section">
    <h3 class="pro-heading">Electricity Bill</h3>
    <div class="pro-row">
      <div class="pro-card">Power Saver</div>
      <div class="pro-card">Energy Plus</div>
      <div class="pro-card">Utility Rewards</div>
    </div>
  </div>

  <div class="pro-section">
    <h3 class="pro-heading">Online Shopping</h3>
    <div class="pro-row">
      <div class="pro-card">Amazon Rewards</div>
      <div class="pro-card">Flipkart Axis</div>
      <div class="pro-card">Smart Buy</div>
    </div>
  </div>

  <div class="pro-section">
    <h3 class="pro-heading">Offline Shopping</h3>
    <div class="pro-row">
      <div class="pro-card">Retail Plus</div>
      <div class="pro-card">City Rewards</div>
      <div class="pro-card">Store Saver</div>
    </div>
  </div>

  <div class="pro-section">
    <h3 class="pro-heading">Traveling</h3>
    <div class="pro-row">
      <div class="pro-card">Vistara Signature</div>
      <div class="pro-card">IndiGo Card</div>
      <div class="pro-card">Miles Pro</div>
    </div>
  </div>

</div>


<script>
document.querySelectorAll('.pro-card').forEach(card => {
    card.addEventListener('click', function () {
        this.classList.toggle('selected');
    });
});
</script>







@endsection
