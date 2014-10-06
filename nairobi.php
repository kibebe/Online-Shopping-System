
<html>
<head>
<title>Nairobi matt</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script language="JavaScript" type="text/javascript" src="js/bootstrap.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/notify.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.json-2.4.min.js"></script>
<link href="project.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor='#CC99FF'>

<p>


<h1><img src="tumaini.png"/></h1>
<div class="header">
<table border="0">
  <tr>
    <td width="60"><a href="index.html">Home</a></td>
    <td width="130"><a href="managerLogin.php">Manager Login</a></td>
	<td><a href="contact.php">Contact us</a></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</p>
<h2>Enter your name and location and add items to cart</h2>
<?php
//connect to the database
$con = mysql_connect("localhost","cik","mzuka");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  } 
mysql_select_db("tumaini", $con);
$sql="SELECT * FROM products WHERE branch='Nairobi'";
$result = mysql_query($sql,$con);

echo '<table class="table table-striped table-hover">';
echo '<tr>';
echo '<td class="col-xs-2">Customers name</td>';
echo '<td class="col-xs-2"><input class="form-control" name="txtcname" type="text" id="txtcname" /></td>';
echo '<td class="col-xs-2">Location</td>';
echo '<td class="col-xs-2"><select name="location">
<option value=""> Select a location</option>
<option value="nairobi"> Around Nairobi</option>
<option value="mombasa"> Around Mombasa</option>
<option value="nakuru"> Around Nakuru</option>
<option value="kisumu"> Around kisumu</option>
</select>
</td>';
echo '<td class="col-xs-2">&nbsp;</td>';
echo '<td class="col-xs-2">&nbsp;</td>';

echo '</tr>';
echo '</table>';
//table containing the cart
echo '<table id="cart" border=\'0\' class="table table-striped table-hover">
<caption style="color:#33FF00">Cart</caption>
<tr bgcolor=grey>
<th >Description</th>
<th>Price</th>
<th>Quantity</th>
<th>Sub Total</th>
</tr>';
echo '</table>';

echo '<input class="btn btn-primary checkout" type="button"  value="Checkout" />';
//products table
echo '<table id=\'products\' border=\'1\' class="table table-striped table-hover">
<tr bgcolor=grey>
<th>Description</th>
<th>Unit</th>
<th>Price</th>
<th>Branch</th>
<th>Quantity</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>Sub Total</th>
</tr>';
while($row = mysql_fetch_assoc($result))
  {
  echo '<tr data-description="' . $row['description'] .'" data-price="' . $row['price'] . '" data-id="' . $row['P_ID'] . '"data-branch="' . $row['branch'].'">';
  echo "<td>" . $row['description'] . "</td>";
   echo "<td>" . $row['unit'] . "</td>";   
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['branch'] . "</td>";
  echo "<td>" . '<div class="col-xs-30"><input class="form-control quantity" name="txtqty" type="text" /></div>' . "</td>";
  echo "<td>" . '<input class="btn btn-info add" type="button"  value="Add to cart" />' . "</td>";
  echo "<td>" . '<input class="btn btn-info update" type="button"  value="Update" />' . "</td>";
  echo "<td>" . '<input class="btn btn-info remove" type="button"  value="Remove from cart" />' . "</td>";
  echo "<td>" . '<div class="subtotal"></div>' . "</td>";
  echo "</tr>";
  }
echo "</table>";

echo '<form id="cart-form" action="orders_kisumu.php" method="post"><input name="data" type="hidden"/></form>';

?> 

	
<script type="text/javascript">
var cart_items = {};
var $branchs='';
function removeCart(id)
{
    var item = cart_items[id];
    
    if(!(typeof item == 'undefined'))
    {
        delete cart_items[id];
        var $rows = $('tr', '#cart');
        $rows.each(
            function()
            {
                var $this = $(this);
                if($this.data('id') == id)
                {
                    $this.remove();
                    return;
                }
            }
        );
        cartTotal();
    }
}

function addItem(id, description, price, quantity, subtotal)
{
    var item = cart_items[id];
    
    if(typeof item == 'undefined')
    {
        cart_items[id] = {description: description, price: price, quantity: quantity,subtotal: subtotal,pid: id};
        var $table = $('#cart'), $item = $('<tr></tr>').data('id', id), $description = $('<td></td>'), $price = $('<td></td>'), $quantity = $('<td class="quantity"></td>'), $subtotal = $('<td class="subtotal"></td>'), $checkout = $('.checkout');
        $description.html(cart_items[id]['description']);
        $price.html(cart_items[id]['price']);
        $quantity.html(cart_items[id]['quantity']);
        $subtotal.html(subtotal);
        $item.append($description, $price, $quantity, $subtotal);
        $table.append($item);
        $table.show();
        $checkout.show();
        cartTotal();
    }
}

function updateCart(id, description, price, quantity, subtotal)
{
    var item = cart_items[id];
    
    if(!(typeof item == 'undefined'))
    {
        cart_items[id] = {description: description, price: price, quantity: quantity,subtotal:subtotal,pid:id};
        var $rows = $('tr', '#cart');
        $rows.each(
            function()
            {
                var $this = $(this);
                if($this.data('id') == id)
                {
                    var $quantity = $this.find('.quantity'), $subtotal = $this.find('.subtotal');
                    $quantity.html(quantity);
                    $subtotal.html(subtotal);
                    return;
                }
            }
        );
        cartTotal();
    }
}

function cartTotal()
{
     var $table = $('#cart'), $subtotals = $('.subtotal', '#cart'), total = 0, $total = $('.total_tr', '#cart');
     $subtotals.each(
        function()
        {
            var $this = $(this);
            total += parseInt($this.html(), 10);
        }
     );
     if($total.length)
     {
        $total.remove();
     }
    
    $total = $('<tr class="total_tr"></tr>');
    var $caption_td = $('<td class="total">Total:</td>'), $empty = $('<td>&nbsp;</td>'), $empty2=$empty.clone(), $val = $empty.clone().html(total);
   
    $total.append($caption_td, $empty, $empty2, $val.addClass('total'));
    $table.append($total);
     
}

$('.add').on(
'click',
function(evt)
{
    evt.preventDefault();
    var $this = $(this), $parent = $this.parents('tr').first(), quantity = $parent.find('.quantity').val(), $subtotal = $parent.find('.subtotal');
    if(parseInt(quantity, 10))
    {
	$branchs=$parent.data('branch');
	
        var subtotal = parseInt($parent.data('price'), 10) * quantity;
        $subtotal.html(subtotal);
        addItem($parent.data('id'), $parent.data('description'), $parent.data('price'), quantity, subtotal);
    }
}
);

$('.update').on(
'click',
function(evt)
{
    evt.preventDefault();
    var $this = $(this), $parent = $this.parents('tr').first(), quantity = $parent.find('.quantity').val(), $subtotal = $parent.find('.subtotal');
    if(parseInt(quantity, 10))
    {
        var subtotal = parseInt($parent.data('price'), 10) * quantity;
        $subtotal.html(subtotal);
        updateCart($parent.data('id'), $parent.data('description'), $parent.data('price'), quantity, subtotal);
    }
}
);

$('.remove').on(
'click',
function(evt)
{
    evt.preventDefault();
    var $this = $(this), $parent = $this.parents('tr').first(), $quantity = $parent.find('.quantity'), $subtotal = $parent.find('.subtotal');
    $quantity.val(0);
    $subtotal.html(0);
    
    removeCart($parent.data('id'));
}
);

function countProperties(obj) {
    var count = 0;

    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            ++count;
    }

    return count;
}


$('.checkout').on(
'click',
function(evt)
{
    evt.preventDefault();
    
    var length = countProperties(cart_items), $this=$(this);
    
    if(!length)
    {
        $this.notify('Your cart is empty!!!');

        return;
    }
    
    var $name = $('#txtcname'), $location = $('select[name=location]'), $form = $('#cart-form'), $input = $form.find('input[name=data]'),$totalO =$('.total_tr td:eq(3)');
    if(!$name.val())
    {
        $name.notify('Kindly, enter your name!!!');
        return;
    }
    
    if(!$location.val())
    {
        $location.notify('Kindly, enter your location!!!');
        return;
    }
    
    var data = {};
    
    data['items'] = cart_items;
    data['branch']=$branchs;
    data['location'] = $location.val();
    data['name'] = $name.val();
    data['total']= $totalO.html();
    $input.val($.toJSON(data));
    
    $form.submit();
    
}
);
</script>
</body>
</html>


