-- =============================================================================
-- STEM Robotics Learning Platform - Seed Data
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------------------------
-- 1. Roles & Permissions (Spatie)
-- -----------------------------------------------------------------------------
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'web', NOW(), NOW()),
(2, 'Coordinator', 'web', NOW(), NOW()),
(3, 'Teacher', 'web', NOW(), NOW()),
(4, 'Student', 'web', NOW(), NOW());

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'createSchool', 'web', NOW(), NOW()),
(2, 'seeSchools', 'web', NOW(), NOW()),
(3, 'editSchools', 'web', NOW(), NOW()),
(4, 'createCoordinator', 'web', NOW(), NOW()),
(5, 'seeCoordinators', 'web', NOW(), NOW()),
(6, 'editCoordinators', 'web', NOW(), NOW()),
(7, 'createCategory', 'web', NOW(), NOW()),
(8, 'seeCategory', 'web', NOW(), NOW()),
(9, 'editCategory', 'web', NOW(), NOW()),
(10, 'createSubcategory', 'web', NOW(), NOW()),
(11, 'seeSubcategory', 'web', NOW(), NOW()),
(12, 'editSubcategory', 'web', NOW(), NOW()),
(13, 'createTeachers', 'web', NOW(), NOW()),
(14, 'seeTeachers', 'web', NOW(), NOW()),
(15, 'editTeachers', 'web', NOW(), NOW()),
(16, 'createStudents', 'web', NOW(), NOW()),
(17, 'seeStudents', 'web', NOW(), NOW()),
(18, 'editStudents', 'web', NOW(), NOW()),
(19, 'createClassrooms', 'web', NOW(), NOW()),
(20, 'seeClassrooms', 'web', NOW(), NOW()),
(21, 'editClassrooms', 'web', NOW(), NOW()),
(22, 'seeHomeworks', 'web', NOW(), NOW()),
(23, 'editHomeworks', 'web', NOW(), NOW());

-- Role has permissions
-- Administrator gets 1..12
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1),
(7, 1), (8, 1), (9, 1), (10, 1), (11, 1), (12, 1);

-- Coordinator gets 13..21
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(13, 2), (14, 2), (15, 2), (16, 2), (17, 2), (18, 2), (19, 2), (20, 2), (21, 2);

-- Teacher gets 17, 20, 22, 23
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(17, 3), (20, 3), (22, 3), (23, 3);

-- -----------------------------------------------------------------------------
-- 2. Core Users (bcrypt hashed passwords)
-- password for all test accounts is 'password' or username-based:
-- admin / admin: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi ('password')
-- -----------------------------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `is_enable`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 'admin@example.com', '3101234567', 'Administrator', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(2, 'Coordinadora Miel Claretiano', 'miel@example.com', '3119876543', 'Coordinator', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(3, 'Coordinador Mazuera', 'claretiano@example.com', '3124567890', 'Coordinator', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(4, 'Profesor Carlos Robótica', 'carlos@example.com', '3131112233', 'Teacher', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(5, 'Profesor David Electrónica', 'davidca@example.com', '3142223344', 'Teacher', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(6, 'Profesora Claudia STEM', 'claudia@example.com', '3153334455', 'Teacher', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(7, 'Profesor Diego Domótica', 'diegofo@example.com', '3164445566', 'Teacher', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(8, 'Andrea Ospina (Estudiante)', 'student@example.com', '3175556677', 'Student', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(9, 'Fernando Hurtado (Estudiante)', 'fernandohu@example.com', '3186667788', 'Student', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(10, 'Diana Guzmán (Estudiante)', 'dianagu@example.com', '3197778899', 'Student', 1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Model has roles
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10);

-- -----------------------------------------------------------------------------
-- 3. Schools & Coordinators
-- -----------------------------------------------------------------------------
INSERT INTO `schools` (`id`, `name`, `address`, `city`, `country`, `icon_url`, `is_enable`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Colegio Claretiano de Bosa', 'Carrera 80J # 68-15 Sur', 'Bogota', 'Colombia', 'https://cdn-icons-png.flaticon.com/512/2997/2997295.png', 1, 0, NOW(), NOW()),
(2, 'Colegio Mayor de Mazuera', 'Calle 40 Sur # 78-20', 'Bogota', 'Colombia', 'https://cdn-icons-png.flaticon.com/512/2997/2997295.png', 1, 0, NOW(), NOW());

INSERT INTO `coordinators` (`id`, `user_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NOW(), NOW()),
(2, 3, 2, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 4. Teachers
-- -----------------------------------------------------------------------------
INSERT INTO `teachers` (`id`, `user_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, NOW(), NOW()),
(2, 5, 1, NOW(), NOW()),
(3, 6, 2, NOW(), NOW()),
(4, 7, 2, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 5. Classrooms
-- -----------------------------------------------------------------------------
INSERT INTO `classrooms` (`id`, `name`, `code`, `user_id`, `school_id`, `created_at`, `updated_at`) VALUES
(1, 'Robótica Móvil 607', 'RODO607', 4, 1, NOW(), NOW()),
(2, 'Robótica Industrial 802', 'ROIN802', 5, 1, NOW(), NOW()),
(3, 'Domótica Infantil 305', 'DONI305', 6, 2, NOW(), NOW()),
(4, 'Automatización Escolar 403', 'DOES403', 7, 2, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 6. Students
-- -----------------------------------------------------------------------------
INSERT INTO `students` (`id`, `user_id`, `school_id`, `classroom_id`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 1, NOW(), NOW()),
(2, 9, 1, 1, NOW(), NOW()),
(3, 10, 1, 1, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 7. Curricular Categories & Subcategories
-- -----------------------------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `description`, `icon_url`, `created_at`, `updated_at`) VALUES
(1, 'Robótica y Mecatrónica', 'Construcción y diseño de estructuras robóticas, cinemática y actuadores mecánicos.', 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png', NOW(), NOW()),
(2, 'Programación y Algoritmia para Niños', 'Pensamiento computacional, lógica de bloques y primeros pasos en código.', 'https://cdn-icons-png.flaticon.com/512/1005/1005141.png', NOW(), NOW()),
(3, 'Electrónica y Microcontroladores', 'Fundamentos de circuitos, protoboards y microcontroladores educativos.', 'https://cdn-icons-png.flaticon.com/512/2991/2991148.png', NOW(), NOW()),
(4, 'Diseño e Impresión 3D', 'Modelado digital para piezas personalizadas y prototipos de ingeniería escolar.', 'https://cdn-icons-png.flaticon.com/512/2888/2888704.png', NOW(), NOW()),
(5, 'Inteligencia Artificial e IoT Escolar', 'Introducción interactiva a visión por computador y automatización.', 'https://cdn-icons-png.flaticon.com/512/8618/8618881.png', NOW(), NOW());

INSERT INTO `subcategories` (`id`, `name`, `description`, `icon_url`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Sensores y Actuadores', 'Integración de sensores infrarrojos, ultrasónicos y servomotores.', 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png', 1, NOW(), NOW()),
(2, 'Mecanismos y Engranajes', 'Transmisión de potencia, relaciones y chasis robóticos.', 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png', 1, NOW(), NOW()),
(3, 'Robots Móviles y Seguidores de Línea', 'Navegación autónoma y seguimiento óptico en pistas de retos.', 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png', 1, NOW(), NOW()),
(4, 'Scratch y Programación Visual', 'Animaciones interactivas y control de robots por bloques.', 'https://cdn-icons-png.flaticon.com/512/1005/1005141.png', 2, NOW(), NOW()),
(5, 'Python para Microcontroladores', 'Sintaxis básica y scripts para control de hardware interactivo.', 'https://cdn-icons-png.flaticon.com/512/1005/1005141.png', 2, NOW(), NOW()),
(6, 'Circuitos Básicos y LEDs', 'Leyes fundamentales, interruptores y circuitos lumínicos.', 'https://cdn-icons-png.flaticon.com/512/2991/2991148.png', 3, NOW(), NOW()),
(7, 'Arduino para Escuelas', 'Lectura analógica/digital y control de periféricos.', 'https://cdn-icons-png.flaticon.com/512/2991/2991148.png', 3, NOW(), NOW()),
(8, 'Modelado Digital en Tinkercad', 'Diseño volumétrico intuitivo de componentes robóticos.', 'https://cdn-icons-png.flaticon.com/512/2888/2888704.png', 4, NOW(), NOW()),
(9, 'Domótica y Automatización del Aula', 'Dispositivos inteligentes conectados para confort y seguridad.', 'https://cdn-icons-png.flaticon.com/512/8618/8618881.png', 5, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 8. Hands-on Robotics Projects
-- -----------------------------------------------------------------------------
INSERT INTO `projects` (`id`, `name`, `icon_url`, `description`, `theme_type`, `is_enable`, `is_file`, `user_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(1, 'Brazo Robótico con Servomotores', 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png', 'Construcción de un brazo robótico articulado de 3 grados de libertad controlado con potenciómetros analógicos y microcontrolador.', 'project', 1, 0, 4, 1, NOW(), NOW()),
(2, 'Robot Seguidor de Línea de Alta Velocidad', 'https://cdn-icons-png.flaticon.com/512/2040/2040504.png', 'Vehículo robótico autónomo con sensor reflectivo TCRT5000 y control de velocidad diferencial con algoritmo proporcional.', 'project', 1, 0, 4, 3, NOW(), NOW()),
(3, 'Semáforo Inteligente con Arduino', 'https://cdn-icons-png.flaticon.com/512/2991/2991148.png', 'Simulación de cruce vehicular con temporización por software y pulsador peatonal con buzzer acústico de alerta.', 'project', 1, 0, 5, 7, NOW(), NOW()),
(4, 'Estación Meteorológica Escolar IoT', 'https://cdn-icons-png.flaticon.com/512/8618/8618881.png', 'Monitoreo de temperatura, humedad y luminosidad del aula en tiempo real con visualización gráfica en dashboard web.', 'project', 1, 0, 6, 9, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 9. Syllabi (Projects assigned to Classrooms)
-- -----------------------------------------------------------------------------
INSERT INTO `syllabi` (`id`, `classroom_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NOW(), NOW()),
(2, 1, 2, NOW(), NOW()),
(3, 2, 3, NOW(), NOW()),
(4, 3, 4, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 10. Homeworks (Challenges) & Student Uploads
-- -----------------------------------------------------------------------------
INSERT INTO `homework` (`id`, `name`, `description`, `delivery_date`, `classroom_id`, `created_at`, `updated_at`) VALUES
(1, 'Calibración de Sensores Infrarrojos', 'Realizar la calibración en banco de pruebas del sensor óptico y registrar los valores analógicos mínimos y máximos en el reporte.', '2026-12-15', 1, NOW(), NOW()),
(2, 'Diagrama de Flujo del Robot Seguidor', 'Diseñar el diagrama de lógica algorítmica para la toma de decisiones al perder la línea de contraste negro sobre blanco.', '2026-12-20', 1, NOW(), NOW());

INSERT INTO `uploaded_homeworks` (`id`, `path`, `status`, `score`, `delivery_at`, `homework_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'storage/homework_files/calibracion_andrea.pdf', 'scored', 95, '2026-12-14 15:30:00', 1, 8, NOW(), NOW()),
(2, 'storage/homework_files/calibracion_fernando.pdf', 'scored', 88, '2026-12-14 17:45:00', 1, 9, NOW(), NOW()),
(3, 'storage/homework_files/diagrama_andrea.pdf', 'send', 0, '2026-12-19 11:20:00', 2, 8, NOW(), NOW()),
(4, NULL, 'notUploaded', 0, NULL, 2, 9, NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 11. Academic Histories
-- -----------------------------------------------------------------------------
INSERT INTO `academic_histories` (`id`, `user_id`, `classroom_id`, `totalScore`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 95, NOW(), NOW()),
(2, 9, 1, 88, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
