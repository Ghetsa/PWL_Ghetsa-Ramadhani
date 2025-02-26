<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<div class="container">
    <h2>Transaksi POS</h2>

    <!-- Tabel Daftar Barang -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="cart-items">
            <!-- Data akan ditambahkan secara dinamis -->
        </tbody>
    </table>

    <!-- Total Transaksi -->
    <h4>Total: Rp <span id="total">0</span></h4>

    <!-- Tombol Bayar -->
    <button class="btn btn-success" onclick="checkout()">Bayar</button>
</div>

<script>
    let cart = [];
    
    function addToCart(name, price) {
        let item = cart.find(i => i.name === name);
        if (item) {
            item.qty++;
        } else {
            cart.push({ name, price, qty: 1 });
        }
        updateCart();
    }

    function updateCart() {
        let cartItems = document.getElementById("cart-items");
        let total = 0;
        cartItems.innerHTML = "";

        cart.forEach((item, index) => {
            let subtotal = item.price * item.qty;
            total += subtotal;

            cartItems.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>Rp ${item.price}</td>
                    <td><input type="number" value="${item.qty}" min="1" onchange="updateQty(${index}, this.value)"></td>
                    <td>Rp ${subtotal}</td>
                    <td><button class="btn btn-danger" onclick="removeItem(${index})">Hapus</button></td>
                </tr>
            `;
        });

        document.getElementById("total").innerText = total;
    }

    function updateQty(index, qty) {
        cart[index].qty = parseInt(qty);
        updateCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
    }

    function checkout() {
        alert("Transaksi berhasil!");
        cart = [];
        updateCart();
    }
</script>


</body>
</html>