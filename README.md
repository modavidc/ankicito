# 🧠 **Ankicito**

**Ankicito** es una aplicación diseñada para ayudar a estudiantes y profesionales a optimizar su tiempo de estudio generando automáticamente tarjetas de **Anki** a partir de cualquier texto. Con Ankicito, puedes registrar notas clave, generar tarjetas de estudio contextualizadas y mejorar tu aprendizaje de forma rápida y efectiva.

## ✨ Características

- 🕒 **Ahorro de tiempo**: Transforma cualquier texto en tarjetas de **Anki**, ahorrándote horas de creación manual.
- 🤖 **Generación automática de tarjetas**: Convierte notas clave en tarjetas de estudio en cuestión de segundos.
- 🔗 **Integración con Anki**: Ankicito permite la importación automática de tarjetas generadas con un solo clic, mejorando el flujo de trabajo y la experiencia de estudio.

## ⭐ Funcionalidades principales

1. ✍️ **Apunta**: Registra tus notas clave fácilmente dentro de la app.
2. 🔄 **Genera**: Genera tarjetas de estudio contextualizadas para **Anki**.
3. 🎯 **Estudia**: Mejora tu aprendizaje usando las tarjetas en **Anki**.

## 💻 Tecnologías usadas

- 🖥️ **Backend**: PHP con Laravel
- 🔗 **Integración con Anki**: [AnkiConnect](https://foosoft.net/projects/anki-connect/) (API para interactuar con **Anki**)
- ☁️ **Infraestructura**: AWS (con servicios como EC2, Lambda, Lightsail, etc.)
- 🐳 **Contenedores**: Docker (opcional, para contenerizar la app)

## 📦 Requisitos

### 🖥️ Requisitos del sistema

- 🐘 **PHP** 8.0 o superior.
- 🛠️ **Composer** para la gestión de dependencias.
- 🐳 **Docker** (opcional, para contenedores).
- 🔐 **Cuenta de Anki** (para usar la integración con **AnkiConnect**).

### ⚙️ Requisitos de software

1. **Instalación de PHP y Composer**:
    - Descarga **PHP** desde [aquí](https://www.php.net/downloads).
    - Instala **Composer** siguiendo la guía oficial [aquí](https://getcomposer.org/download/).

2. **Instalación de Docker** (opcional):
    - Si deseas usar contenedores, instala **Docker** desde [aquí](https://www.docker.com/products/docker-desktop).

## 🔧 Instalación

1. Clona el repositorio de Ankicito:
    ```bash
    git clone https://github.com/modavidc/ankicito.git
    ```
2. Navega al directorio del proyecto:
    ```bash
    cd ankicito
    ```
3. Instala las dependencias con Composer:
    ```bash
    composer install
    ```
4. Configura tus variables de entorno en el archivo `.env` (consulta el archivo `.env.example` para referencia).

5. Inicia el servidor de desarrollo:
    ```bash
    php artisan serve
    ```

## ⚡ Configuración de **AnkiConnect**

Para que **Ankicito** funcione correctamente con **Anki**, es necesario configurar **AnkiConnect** para permitir solicitudes desde la URL donde estará desplegado. Sigue estos pasos para realizar la configuración:

1. Localiza el archivo `config.json` de **AnkiConnect** en tu sistema.

    El archivo config.json se encuentra en el directorio de datos de AnkiConnect en tu sistema. Aquí te indicamos las ubicaciones comunes según tu sistema operativo. Si tienes dudas adicionales, consulta la documentación oficial.
    
    - Para Windows: 
    ```bash
    %APPDATA%\Anki2\addons21\2055492159\config.json
    ```
    
    - Para Mac: 
    ```bash
    ~/Library/Application Support/Anki2/addons21/2055492159/config.json
    ```
    
    - Para Linux: 
    ```bash
    ~/.local/share/Anki2/addons21/2055492159/config.json
    ```    

2. Configura el archivo config.json:
   
    Una vez localices el archivo, abrelo y asegúrate de que tenga la siguiente configuración. Recuerda ajustar la URL según tu entorno de desarrollo o producción:

   - Para pruebas locales (`localhost`):
     ```json
     {
         "apiKey": null,
         "apiLogPath": null,
         "ignoreOriginList": [],
         "webBindAddress": "127.0.0.1",
         "webBindPort": 8765,
         "webCorsOriginList": [
             "http://localhost:8000"
         ]
     }
     ```
   - Para desarrollo (por ejemplo, `dev.ankicito.modavidc.com`):
     ```json
     {
         "apiKey": null,
         "apiLogPath": null,
         "ignoreOriginList": [],
         "webBindAddress": "127.0.0.1",
         "webBindPort": 8765,
         "webCorsOriginList": [
             "dev.ankicito.modavidc.com"
         ]
     }
     ```

3. Guarda los cambios y ¡Listo! 🎉

Con esto, AnkiConnect debería estar correctamente configurado para que Ankicito pueda interactuar con Anki.

## ☁️ Despliegue en AWS

Ankicito puede ser desplegado en AWS usando varios métodos. Aquí tienes una lista de las opciones de despliegue recomendadas:

- **AWS Lightsail**: Despliegue sencillo para apps pequeñas.
- **AWS Elastic Beanstalk**: Solución automática para la gestión de la infraestructura.
- **EC2**: Despliegue manual y control total sobre la infraestructura.
- **AWS CodePipeline**: Automatización del ciclo de vida del despliegue.
- **AWS Lambda con API Gateway**: Despliegue sin servidor para apps event-driven.
- **AWS Fargate con contenedores**: Ejecución de contenedores sin gestionar servidores.
- **AWS EKS**: Kubernetes administrado para aplicaciones basadas en contenedores.
- **Terraform**: Infraestructura como código (multi-cloud).

Consulta la documentación en cada servicio de AWS para configurar el despliegue de la app de acuerdo a tus necesidades específicas.

## 🛠️ Contribuir

1. Haz un fork del proyecto.
2. Crea una rama para tu función (`git checkout -b feature/nueva-funcion`).
3. Haz commit de tus cambios (`git commit -m 'Agrega nueva función'`).
4. Haz push de la rama (`git push origin feature/nueva-funcion`).
5. Abre un Pull Request.

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.