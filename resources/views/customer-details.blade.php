@extends ('layouts.customer')

@section ('content')


<!-- products -->
<body class="customer-details">
  <div class="iphone">
  <form action="" class="form" method="POST">
    <div class="address">
      <h2>Address</h2>

      <div class="card"> 
        <address class="address">
          <strong>Camille Tabanao</strong> <br>
          <input type="tel" placeholder="Phone number" pattern="[0-9]{10}" required><br>
         Date to be rented: <input type="date" placeholder="Date" required><br>
         Time to be rented: <input type="time" placeholder="Time" required><br>
          <h5>Upload ID</h5><input type="file" name="file" placeholder="Upload ID" required>
        </address>
      </div>
    </div>

    <fieldset>
      <legend>Payment Method</legend>

      <div class="form__radios">
        <div class="form__radio">
          <label for="cash">
                Cash Payment
          </label>
          <input checked id="visa" name="payment-method" type="radio" />
        </div>

        <div class="form__radio">
          <label for="gcash">Gcash</label>
          <input id="gcash" name="payment-method" type="radio" />
        </div>
      </div>
    </fieldset>

    <div>
      <h2>Bill</h2>

      <table>
        <tbody>
          <tr>
            <td>Prom Gown 1</td>
            <td style="text-align:right;">P3,000</td>
          </tr>
          <tr>
            <td><small style="text-transform:none">*size: extra small</small></td>
          </tr>
          <tr>
            <td><small style="text-transform:none">*quantity: 1</small></td>
          </tr>
        <tfoot>        
          <tr>
            <td>Total</td>
            <td style="text-align:right;">P3,000</td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div>
      <button class="button button--full" type="submit"><svg class="icon-details">
          <use xlink:href="#icon-shopping-bag" />
        </svg><a style="text-decoration: none; color: white;" href="{{route('customer-receipt')}}">Rent Now</a></button>
    </div>
  </form>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none">

  <symbol id="icon-shopping-bag" viewBox="0 0 24 24">
    <path d="M20 7h-4v-3c0-2.209-1.791-4-4-4s-4 1.791-4 4v3h-4l-2 17h20l-2-17zm-11-3c0-1.654 1.346-3 3-3s3 1.346 3 3v3h-6v-3zm-4.751 18l1.529-13h2.222v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h6v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h2.222l1.529 13h-15.502z" />
  </symbol>

</svg>
</body>
</html>

@endsection 