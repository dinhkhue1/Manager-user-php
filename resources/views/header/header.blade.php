<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-size: 28px;
      margin: auto;
    }
    .header {
      width: 100%;
      display: flex;
      justify-content: space-between;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
      position: -webkit-sticky;
      position: sticky;
      top: 0;
    }

    ul {
      list-style-type: none;
    }

    li {
      float: left;
    }

    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    li a:hover {
      background-color: #111;
    }

    .active {
      background-color: #4CAF50;
    }
    .profile{
      color: white;
      align-items: center;
      display: flex;
      margin: 0px 20px -12px 0px;
    }
    .profile-name{
      display: flex;
      margin-right: 20px;
      height: 100%;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="memu">
      <ul id="menu">
        <li><a href="{{ route('manager-user') }}" {{ Request::is('manager-user*') ? 'class=active' : '' }}>User</a></li>
        <li><a href="{{ route('create-user') }}" {{ Request::is('create-user*') ? 'class=active' : '' }}>Contact</a></li>
      </ul>
    </div>
    <div class="profile">
      <div class="profile-name">
        <img id="img" src="" alt="User Image" style="max-width: 50px; max-height: 50px; border-radius: 100%; ">
        <p id="userName" style="margin: 15px 30px 0px 5px;"></p>
      </div>
      
      <div class="login">
        <a href="{{route('login')}}" class="btn btn-primary float-end" style="margin-bottom: 10px; width: 80px">login</a>
      </div>
    </div>
  </div>
  
  <script>
    // JavaScript để xử lý sự kiện khi một mục được chọn
    document.addEventListener('DOMContentLoaded', function () {
      var menuItems = document.querySelectorAll('#menu a');

      menuItems.forEach(function (item) {
        item.addEventListener('click', function () {
          // Xóa lớp 'active' từ tất cả các mục
          menuItems.forEach(function (menuItem) {
            menuItem.classList.remove('active');
          });

          // Thêm lớp 'active' cho mục được chọn
          item.classList.add('active');
        });
      });

      const token = localStorage.getItem('access_token');
      if (token) {
        fetch('{{ route("profile") }}', {
          method: 'GET',
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
          },
        })
        .then(response => {
          if (!response.ok) {
            const imgElement = document.getElementById('img');
            imgElement.style.display = 'none';
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          console.log('Profile data:', data);
          document.getElementById('userName').textContent = data.name? data.name : '';
          const imgElement = document.getElementById('img');
          if (data.img) {
              imgElement.src = 'data:image/jpeg;base64,' + data.img;
          } else {
              imgElement.style.display = 'none';
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      } else {
        console.log('Token is missing. Please log in.');p
      }
    });
  </script>
</body>
</html>