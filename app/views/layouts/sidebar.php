<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">

    <h4 class="text-center">🏨 Hotel</h4>
    <hr>

    <p>👤 <?= $_SESSION['user']['name'] ?></p>

    <ul class="nav flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="<?= BASE_URL ?>dashboard.php" class="nav-link text-white">📊 Dashboard</a>
        </li>

        <!-- ADMIN -->
        <?php if($_SESSION['user']['role_id'] == 1): ?>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>users.php" class="nav-link text-white">👥 Usuarios</a>
        </li>
        <?php endif; ?>

        <!-- ADMIN + GERENTE -->
        <?php if(in_array($_SESSION['user']['role_id'], [1,2])): ?>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>rooms.php" class="nav-link text-white">🏨 Habitaciones</a>
        </li>
        <?php endif; ?>

        <?php if(in_array($_SESSION['user']['role_id'], [1,2])): ?>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>offers.php" class="nav-link text-white">
                💼 Ofertas
            </a>
        </li>
        <?php endif; ?>

        <!-- ADMIN + GERENTE + RECEPCIONISTA -->
        <?php if(in_array($_SESSION['user']['role_id'], [1,2,3])): ?>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>bookings.php" class="nav-link text-white">📅 Reservas</a>
        </li>
        <?php endif; ?>

        <!-- CLIENTE -->
        <?php if($_SESSION['user']['role_id'] == 4): ?>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>create_booking.php" class="nav-link text-white">🛎 Reservar</a>
        </li>
        <?php endif; ?>

        

        <?php if($_SESSION['user']['role_id'] == 5): ?>

            <li class="nav-item">
              <a href="<?= BASE_URL ?>supplies.php" class="nav-link text-white">
                  📦 Suministros
               </a>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL ?>my_offers.php" class="nav-link text-white">
                     💰 Mis ofertas
              </a>
            </li>
        <?php endif; ?>

        <!-- LOGOUT -->
        <li class="nav-item">
            <a href="<?= BASE_URL ?>logout.php" class="nav-link text-danger">🚪 Salir</a>
        </li>

    </ul>
</div>

<div class="flex-grow-1 p-4">