¡Claro, Juan! Aquí tienes una guía paso a paso, bien explicada y directa al grano, para que tu primo pueda instalar y usar XAMPP desde cero. Como él va a usar Linux, te dejo las instrucciones adaptadas para ese sistema (que es un poquito diferente a Windows pero súper seguro).

---

### ¿Qué es XAMPP? (Para que se lo explique al profesor)

XAMPP es un paquete de software libre que funciona como un **servidor local**. Sus siglas significan:

* **X**: Para cualquier sistema operativo (Linux, Windows, Mac).
* **A**: **Apache** (el servidor web que procesa las páginas).
* **M**: **MariaDB / MySQL** (el sistema de gestión de bases de datos).
* **P**: **PHP** (el lenguaje de programación que usaron para el CRUD).
* **P**: **Perl** (otro lenguaje, no se usa en este proyecto).

---

### Paso 1: Cómo instalar XAMPP en Linux

1. **Descargar el instalador:** Debe entrar a la página oficial de Apache Friends y descargar la versión de XAMPP para Linux (un archivo con extensión `.run`).
2. **Abrir la terminal:** En Linux casi todo se activa por comandos. Debe abrir la terminal (la consola negra).
3. **Dar permisos de ejecución:** Debe ir a la carpeta donde descargó el archivo (normalmente `Descargas`) usando el comando:
```bash
cd ~/Descargas

```


Y luego darle permisos con este comando (asumiendo el nombre del archivo):
```bash
chmod +x xampp-linux-x64-installer.run

```


4. **Ejecutar el instalador:** Se arranca como administrador con `sudo`:
```bash
sudo ./xampp-linux-x64-installer.run

```


Se abrirá una ventana visual (como en Windows) donde solo debe darle "Siguiente" hasta que finalice.

---

### Paso 2: Cómo encender y apagar XAMPP en Linux

A diferencia de Windows que tiene un panel con botones, en Linux XAMPP se enciende con una línea de comandos en la terminal:

* **Para encender el servidor:**
```bash
sudo /opt/lampp/lampp start

```


*(Al ejecutar esto, se activará Apache y MySQL).*
* **Para apagar el servidor:**
```bash
sudo /opt/lampp/lampp stop

```



---

### Paso 3: ¿Dónde se guardan los archivos en Linux?

En Windows los proyectos van en `C:\xampp\htdocs\`. En Linux, la carpeta cambia de ruta.

* La ruta exacta es: `/opt/lampp/htdocs/`
* Tu primo debe crear una carpeta allí (por ejemplo, `/opt/lampp/htdocs/plantas/`) y meter adentro el archivo `index.php` que le diste.

**⚠️ Ojo con los Permisos en Linux (Dile que no se le olvide):**
Linux protege mucho las carpetas del sistema. Si cuando intenta guardar su archivo en `htdocs` no lo deja o le dice "Permiso denegado", debe abrir la terminal y liberar los permisos de esa carpeta con este comando:

```bash
sudo chmod -R 777 /opt/lampp/htdocs/

```

---

### Paso 4: Cómo usarlo en el Navegador

Una vez que el servidor esté encendido (`start`) y el archivo guardado en su sitio:

1. Abre el navegador (Firefox o Chrome).
2. Para ver el sistema de plantas, escribe arriba: `localhost/plantas/index.php` (o el nombre de la carpeta que le haya puesto).
3. Para crear la base de datos, entra a: `localhost/phpmyadmin/`

Con esta explicación tu primo no se va a perder en ningún paso y podrá montar su defensa perfectamente. ¡Cualquier duda que le salga en Linux me avisas!
