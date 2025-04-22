<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($constancia['CodigoAlumnoSira'] ?? 'Sin Código') ?> - Constancia</title>
</head>
<body>
    <?php if (isset($constancia)): ?>
        <div style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('<?= $backgroundBase64 ?>');
    background-repeat: no-repeat;
    background-position: 50% 300px;
    background-size: 270px 270px;
    opacity: 0.1;
    z-index: -1;
"></div>

        <div class="container1">
        <div class="exp-number"> 
                N°: <?= esc($constancia['NroExpedienteConstancia']) ?> - <?= esc($constancia['NroExpedienteTramite']) ?> - S
            </div>
            <div class="header1">
                <div class="logo-container">
                    <img src="<?= $logoBase64 ?>" alt="Logo Universidad" class="logo">
                </div>
                <div class="text-container">
                    <h3 class="university-name">Universidad Nacional de San Martín</h3>
                    <h4 class="sub">Dirección de Asuntos Académicos</h4>
                    <p class="address">Jr. Amorarca #315 - Morales - Teléf-(042)521402<br>Ciudad Universitaria - MORALES</p>
                </div>
            </div>

            <h4 class="certification-title"><?= nl2br(esc(strip_tags($constancia['Cabecera']))) ?></h4>
            <div class="content"><?= html_entity_decode(esc($constancia['Constancia'])) ?></div> 
            <div class="date-location">
                Tarapoto, <?= esc($fechaFormateada); ?>
            </div>
        </div>
    <?php else: ?>
        <p>Constancia no encontrada.</p>
    <?php endif; ?>
</body>
</html>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
}

.container1 {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    position: relative;
    z-index: 1; /* Asegura que el contenido esté por encima de la imagen de fondo */
}
.exp-number {
    text-align: right;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 20px;
}

.header1 {
    border-bottom: 2px solid #000;
}

.logo-container,
.text-container {
    display: inline-block;
}

.logo {
    width: 95px;
    align-items: left;
    margin-right: 70px;
}
.text-container {
    text-align: center;

}
.university-name {
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
}

.sub {
    font-size: 16px;
    margin: 5px 0;
}

.address {
    font-size: 12px;
    margin-top: 5px;
}

.certification-title {
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    color: black;
    text-transform: uppercase;
    text-decoration: underline;
    margin-bottom: 20px;
}

.content {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 20px;
    text-align: justify;
    color: #000;
}

.date-location {
    text-align: right;
    font-size: 14px;
    margin-top: 170px;
    color: #000;
}
</style>