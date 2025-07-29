-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-07-2025 a las 18:05:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `intelcon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `created_at`, `updated_at`) VALUES
(1, 'Puerto Ayacucho', 1, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(2, 'Barcelona', 2, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(3, 'San Fernando de Apure', 3, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(4, 'Maracay', 4, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(5, 'Barinas', 5, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(6, 'Ciudad Bolívar', 6, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(7, 'Valencia', 7, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(8, 'San Carlos', 8, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(9, 'Tucupita', 9, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(10, 'Caracas', 10, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(11, 'Coro', 11, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(12, 'San Juan de los Morros', 12, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(13, 'Barquisimeto', 13, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(14, 'Mérida', 14, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(15, 'Los Teques', 15, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(16, 'Maturín', 16, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(17, 'La Asunción', 17, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(18, 'Guanare', 18, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(19, 'Cumaná', 19, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(20, 'San Cristóbal', 20, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(21, 'Trujillo', 21, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(22, 'La Guaira', 22, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(23, 'San Felipe', 23, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(24, 'Maracaibo', 24, '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(25, 'El Tigre', 2, '2025-07-26 13:56:05', '2025-07-26 13:56:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `document_type`, `file_path`, `original_name`, `created_at`, `updated_at`) VALUES
(1, 2, 'Cédula de Identidad', 'documents/2/tYE4yC4pIOzLhn10sGjw7qRFAhEPJMNNUpHRa0Q3.jpg', 'classic-lms-01.jpg', '2025-07-29 19:17:13', '2025-07-29 19:17:13'),
(2, 2, 'RIF', 'documents/2/ZFLahW0RLa1L7C7Oue5mqUUzHBRpsE4WJFn2XYa2.jpg', 'course-online-04.jpg', '2025-07-29 19:19:31', '2025-07-29 19:19:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2025_07_16_000000_create_roles_table', 1),
(5, '2025_07_16_000001_create_states_table', 1),
(6, '2025_07_16_000002_create_cities_table', 1),
(7, '2025_07_16_000003_create_municipalities_table', 1),
(8, '2025_07_16_031751_create_users_table', 1),
(9, '2025_07_25_201113_create_payments_table', 1),
(10, '2025_07_25_204546_add_location_fields_to_users_table', 1),
(11, '2025_07_26_095514_create_jobs_table', 1),
(12, '2025_07_28_031804_create_services_table', 2),
(13, '2025_07_28_041106_modify_service_relation_in_users_table', 3),
(14, '2025_07_28_044515_create_service_user_table', 4),
(15, '2025_07_28_053628_create_towers_table', 5),
(16, '2025_07_29_151004_create_documents_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipalities`
--

CREATE TABLE `municipalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `municipalities`
--

INSERT INTO `municipalities` (`id`, `name`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'Municipio Bolívar', 2, NULL, NULL),
(2, 'Municipio Simón Rodríguez', 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `month_paid` varchar(255) NOT NULL,
  `status` enum('paid','pending','overdue') NOT NULL DEFAULT 'pending',
  `receipt_path` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `amount`, `payment_date`, `month_paid`, `status`, `receipt_path`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 50.25, '2025-07-26', '2025-07', 'paid', 'receipts/ckHBJdWxpqOqaMLybwSq5idGx9ScPdFuIhouXmRt.png', 'pagadoo', '2025-07-27 00:23:57', '2025-07-27 12:18:09'),
(2, 1, 50.25, '2025-07-26', '2025-07', 'pending', 'receipts/8izc92tL3uW8jXhvYHp6KGrrckOd3OXT6qyctrCy.png', 'nuevo ejemplo', '2025-07-27 00:29:34', '2025-07-27 00:29:34'),
(3, 1, 50.00, '2025-07-26', '2025-07', 'paid', 'receipts/rUfh1tCkas4pAFmSbxoFYfcPMv9OXJqmMARhifnj.png', 'cvxcvxc', '2025-07-27 00:31:09', '2025-07-28 13:09:17'),
(4, 1, 88.00, '2025-07-26', '2025-07', 'overdue', 'receipts/NeMg4RU4wewfFgVaVu8WrqdONffKZj33ipHm2ehn.png', 'ejemplooo', '2025-07-27 00:44:09', '2025-07-27 00:44:09'),
(5, 2, 85.46, '2025-07-28', '2025-07', 'pending', 'receipts/5qLPG7XnDhay3PO5zabJnA2zy4X0x9fzrXJcKPSu.png', 'nuevooo', '2025-07-28 13:28:25', '2025-07-28 13:28:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(2, 'client', '2025-07-26 13:56:05', '2025-07-26 13:56:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `speed_mbps` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','discontinued') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `speed_mbps`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'plan 50 mgs', 'sdasd', 50, 25.00, 'active', '2025-07-28 07:31:37', '2025-07-28 13:19:26'),
(2, '100 mgs', 'cvxcbb', 100, 30.00, 'active', '2025-07-28 07:33:31', '2025-07-28 07:33:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_user`
--

CREATE TABLE `service_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `service_user`
--

INSERT INTO `service_user` (`id`, `user_id`, `service_id`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, '2025-07-28', NULL, 'active', '2025-07-28 08:54:53', '2025-07-28 09:21:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `states`
--

INSERT INTO `states` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Amazonas', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(2, 'Anzoátegui', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(3, 'Apure', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(4, 'Aragua', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(5, 'Barinas', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(6, 'Bolívar', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(7, 'Carabobo', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(8, 'Cojedes', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(9, 'Delta Amacuro', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(10, 'Distrito Capital', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(11, 'Falcón', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(12, 'Guárico', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(13, 'Lara', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(14, 'Mérida', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(15, 'Miranda', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(16, 'Monagas', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(17, 'Nueva Esparta', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(18, 'Portuguesa', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(19, 'Sucre', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(20, 'Táchira', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(21, 'Trujillo', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(22, 'La Guaira', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(23, 'Yaracuy', '2025-07-26 13:56:05', '2025-07-26 13:56:05'),
(24, 'Zulia', '2025-07-26 13:56:05', '2025-07-26 13:56:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `towers`
--

CREATE TABLE `towers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `municipality_id` bigint(20) UNSIGNED NOT NULL,
  `address` text DEFAULT NULL,
  `capacity` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','maintenance','offline') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `identification` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `municipality_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `identification`, `email`, `email_verified_at`, `password`, `address`, `profile_photo`, `service_id`, `role_id`, `state_id`, `city_id`, `municipality_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Eliecer Jesus', 'Bedoya Carrero', '12345678', 'eliecerbedoya7@gmail.com', '2025-07-26 14:03:57', '$2y$12$akSbmrzC0QAAKgOa.euSu.Zo.936eiouonI95d0XGpc8xH3hZonqG', 'Calle Principal #123', 'profile-photos/Ds040ByxhH3YH3eOHpdAZJ8sMQmIr0ksQVLZ7xGD.png', NULL, 1, 2, 2, 1, 'PFwvCq940hzbt5Rc693dQDoOtxUs5OOAEP28CYKEVJSBm3rhdLxfNSvmzi2g', '2025-07-26 13:56:05', '2025-07-26 14:03:57'),
(2, 'pedro', 'navaja', '123456789', 'pedronavaja@gmail.com', NULL, '$2y$12$1bPMkFA5ermn8HVQN.OMLuxeJR9NjVcbYNZc.4pF3ZtQyco.xzkMK', 'cvxcvxc', 'profile-photos/3vk7dnU5E1PFC0Uv5pgXfTdbuJi0xT52MeMsQEkc.png', NULL, 2, 2, 2, 1, 'nI2L5yFAnmtiGhwf25kij8TrmRn3eADtioA1yyonIRERhKnidxRbzfyaQY6Z', '2025-07-27 12:47:59', '2025-07-28 13:02:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indices de la tabla `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipalities`
--
ALTER TABLE `municipalities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipalities_city_id_foreign` (`city_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `service_user`
--
ALTER TABLE `service_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_user_user_id_foreign` (`user_id`),
  ADD KEY `service_user_service_id_foreign` (`service_id`);

--
-- Indices de la tabla `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `towers`
--
ALTER TABLE `towers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `towers_municipality_id_foreign` (`municipality_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_identification_unique` (`identification`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_state_id_foreign` (`state_id`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_municipality_id_foreign` (`municipality_id`),
  ADD KEY `users_service_id_foreign` (`service_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `municipalities`
--
ALTER TABLE `municipalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `service_user`
--
ALTER TABLE `service_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `towers`
--
ALTER TABLE `towers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `municipalities`
--
ALTER TABLE `municipalities`
  ADD CONSTRAINT `municipalities_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `service_user`
--
ALTER TABLE `service_user`
  ADD CONSTRAINT `service_user_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `towers`
--
ALTER TABLE `towers`
  ADD CONSTRAINT `towers_municipality_id_foreign` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_municipality_id_foreign` FOREIGN KEY (`municipality_id`) REFERENCES `municipalities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
