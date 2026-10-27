-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2026 a las 14:20:29
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
-- Base de datos: `sistema_ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `horaFec_abierto` datetime NOT NULL,
  `horaFec_cerrado` datetime DEFAULT NULL,
  `saldo_inicial` decimal(8,2) NOT NULL,
  `saldo_final` decimal(8,2) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `nombre`, `horaFec_abierto`, `horaFec_cerrado`, `saldo_inicial`, `saldo_final`, `estado`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'CAJ01SUC01', '2026-02-19 22:32:05', '2026-02-19 22:32:05', 0.00, 10000.00, 1, 2, '2026-02-20 03:32:05', '2026-02-20 03:32:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'CREMAS NATURALES', 'PARA TODO TIPO', 1, '2026-02-10 00:11:50', '2026-02-10 00:11:50'),
(2, 'AMEGLOW', 'MARCA PROPIA', 1, '2026-02-10 00:12:15', '2026-02-10 00:12:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caracteristica_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `caracteristica_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-10 00:11:50', '2026-02-10 00:11:50'),
(2, 2, '2026-02-20 01:26:11', '2026-02-20 01:26:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id`, `producto_id`, `categoria_id`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2026-02-13 04:13:35', '2026-02-13 04:13:35'),
(2, 5, 2, '2026-02-20 01:31:56', '2026-02-20 01:31:56'),
(3, 6, 2, '2026-02-20 02:19:47', '2026-02-20 02:19:47'),
(4, 6, 1, '2026-02-20 02:19:57', '2026-02-20 02:19:57'),
(5, 7, 2, '2026-02-20 02:20:02', '2026-02-20 02:20:02'),
(6, 8, 1, '2026-02-20 02:20:09', '2026-02-20 02:20:09'),
(7, 10, 1, NULL, NULL),
(8, 9, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `persona_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-13 04:34:21', '2026-02-13 04:34:21'),
(2, 3, '2026-02-16 00:24:27', '2026-02-16 00:24:27'),
(3, 6, '2026-02-20 17:48:32', '2026-02-20 17:48:32'),
(4, 7, '2026-02-22 21:12:52', '2026-02-22 21:12:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(8,2) UNSIGNED NOT NULL,
  `numero_comprobante` varchar(255) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `comprobante_id` bigint(20) UNSIGNED DEFAULT NULL,
  `proveedore_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `fecha_hora`, `impuesto`, `numero_comprobante`, `total`, `estado`, `comprobante_id`, `proveedore_id`, `created_at`, `updated_at`) VALUES
(1, '2026-02-13 07:53:53', 4446.00, '1', 27846.00, 1, 1, 1, '2026-02-13 12:54:22', '2026-02-13 12:54:22'),
(2, '2026-02-13 07:58:17', 23598.00, '2', 147798.00, 1, 1, 1, '2026-02-13 12:58:43', '2026-02-13 12:58:43'),
(3, '2026-02-13 07:58:51', 21850.00, '3', 136850.00, 1, 1, 1, '2026-02-13 12:59:13', '2026-02-13 12:59:13'),
(4, '2026-02-13 07:59:25', 46000.00, '4', 286000.00, 0, 1, 1, '2026-02-13 12:59:36', '2026-02-13 13:01:32'),
(5, '2026-02-13 08:09:36', 19266.00, '5', 120666.00, 1, 1, 1, '2026-02-13 13:10:38', '2026-02-13 13:10:38'),
(6, '2026-02-15 20:01:09', 16530.00, '6', 103530.00, 1, 1, 2, '2026-02-16 01:03:37', '2026-02-16 01:03:37'),
(7, '2026-02-15 21:16:29', 874000.00, '7', 5474.00, 1, 2, 1, '2026-02-16 02:17:03', '2026-02-16 02:17:03'),
(8, '2026-02-15 21:23:24', 1000.00, '8', 7000.00, 1, 2, 1, '2026-02-16 02:23:38', '2026-02-16 02:23:38'),
(9, '2026-02-15 21:25:43', 0.00, '9', 20000.00, 1, 1, 1, '2026-02-16 02:26:03', '2026-02-16 02:26:03'),
(10, '2026-02-16 21:13:39', 1000.00, '234', 0.00, 1, 1, 1, '2026-02-17 02:13:50', '2026-02-17 02:13:50'),
(11, '2026-02-16 21:31:00', 0.00, '777', 0.00, 1, 3, 1, '2026-02-17 02:31:12', '2026-02-17 02:31:12'),
(12, '2026-02-16 21:34:00', 0.00, '222', 0.00, 1, 1, 1, '2026-02-17 02:34:15', '2026-02-17 02:34:15'),
(13, '2026-02-16 21:35:46', 0.00, '44444', 159580.00, 1, 1, 1, '2026-02-17 02:36:19', '2026-02-17 02:41:10'),
(14, '2026-02-19 21:50:15', 0.00, '234523452345', 6000.00, 1, 1, 1, '2026-02-20 02:50:25', '2026-02-20 02:50:25'),
(15, '2026-02-19 21:50:38', 0.00, 'numerode prueba', 6000.00, 1, 1, 1, '2026-02-20 02:50:59', '2026-02-20 02:50:59'),
(16, '2026-02-19 21:51:19', 0.00, 'nomames wwey', 4000.00, 1, 3, 1, '2026-02-20 02:51:41', '2026-02-20 02:51:41'),
(17, '2026-02-19 22:01:17', 0.00, 'sin 1909', 6.00, 1, 1, 1, '2026-02-20 03:05:53', '2026-02-20 03:05:53'),
(18, '2026-02-21 18:53:03', 0.00, '123123123123', 6000.00, 1, 1, 1, '2026-02-21 23:53:11', '2026-02-21 23:53:11'),
(19, '2026-02-22 18:40:36', 0.00, 'ggggfactuyraadsf', 615000.00, 1, 1, 1, '2026-02-22 23:40:55', '2026-02-22 23:40:55'),
(20, '2026-02-23 19:47:53', 0.00, '12323412341234', 299000.00, 1, 1, 1, '2026-02-24 00:48:29', '2026-02-24 00:48:29'),
(21, '2026-02-23 19:51:05', 0.00, 'asdfasdfas', 6.00, 1, 1, 1, '2026-02-24 00:51:17', '2026-02-24 00:51:17'),
(22, '2026-02-23 19:54:16', 0.00, 'asdfasdf1231231', 6.00, 1, 1, 1, '2026-02-24 00:54:30', '2026-02-24 00:54:30'),
(23, '2026-02-23 19:57:30', 0.00, 'aaaavvvvvv', 6.00, 1, 2, 1, '2026-02-24 01:01:55', '2026-02-24 01:01:55'),
(24, '2026-02-23 20:18:27', 0.00, '123123aa', 6500000.00, 1, 1, 1, '2026-02-24 01:19:36', '2026-02-24 01:19:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_producto`
--

CREATE TABLE `compra_producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compra_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compra_producto`
--

INSERT INTO `compra_producto` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio_compra`, `precio_venta`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 9, 2600.00, 4000.00, '2026-02-13 12:54:22', '2026-02-13 12:54:22'),
(2, 2, 7, 23, 5400.00, 6800.00, '2026-02-13 12:58:43', '2026-02-13 12:58:43'),
(3, 3, 6, 5000, 23.00, 24.00, '2026-02-13 12:59:13', '2026-02-13 12:59:13'),
(4, 4, 5, 20, 12.00, 14.00, '2026-02-13 12:59:36', '2026-02-13 12:59:36'),
(5, 5, 5, 39, 2600.00, 7500.00, '2026-02-13 13:10:38', '2026-02-13 13:10:38'),
(6, 6, 9, 30, 2900.00, 3500.00, '2026-02-16 01:03:37', '2026-02-16 01:03:37'),
(7, 7, 9, 2, 2300.00, 2500.00, '2026-02-16 02:17:03', '2026-02-16 02:17:03'),
(8, 8, 5, 2, 3.00, 4.00, '2026-02-16 02:23:38', '2026-02-16 02:23:38'),
(9, 9, 9, 10, 2000.00, 4000.00, '2026-02-16 02:26:03', '2026-02-16 02:26:03'),
(10, 10, 5, 2, 3.00, 4.00, '2026-02-17 02:13:50', '2026-02-17 02:13:50'),
(11, 11, 5, 2, 3.00, 4.00, '2026-02-17 02:31:12', '2026-02-17 02:31:12'),
(12, 12, 5, 80, 4000.00, 5000.00, '2026-02-17 02:34:15', '2026-02-17 02:34:15'),
(13, 13, 9, 2, 2300.00, 4000.00, '2026-02-17 02:36:19', '2026-02-17 02:36:19'),
(14, 13, 8, 45, 3444.00, 5500.00, '2026-02-17 02:36:19', '2026-02-17 02:36:19'),
(15, 14, 5, 2, 3.00, 4.00, '2026-02-20 02:50:25', '2026-02-20 02:50:25'),
(16, 15, 5, 2, 3.00, 4.00, '2026-02-20 02:50:59', '2026-02-20 02:50:59'),
(17, 16, 5, 2, 2000.00, 4300.00, '2026-02-20 02:51:41', '2026-02-20 02:51:41'),
(18, 17, 5, 2, 3.00, 4.00, '2026-02-20 03:05:53', '2026-02-20 03:05:53'),
(19, 18, 6, 2, 3.00, 4.00, '2026-02-21 23:53:11', '2026-02-21 23:53:11'),
(20, 19, 5, 123, 5000.00, 6000.00, '2026-02-22 23:40:55', '2026-02-22 23:40:55'),
(21, 20, 1, 23, 13000.00, 16000.00, '2026-02-24 00:48:29', '2026-02-24 00:48:29'),
(22, 21, 1, 2, 3.00, 4.00, '2026-02-24 00:51:17', '2026-02-24 00:51:17'),
(23, 22, 1, 2, 3.00, 4.00, '2026-02-24 00:54:30', '2026-02-24 00:54:30'),
(24, 23, 1, 500, 12000.00, 13000.00, '2026-02-24 01:01:55', '2026-02-24 01:01:55'),
(25, 24, 1, 500, 13000.00, 16000.00, '2026-02-24 01:19:36', '2026-02-24 01:19:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobantes`
--

CREATE TABLE `comprobantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_comprobante` varchar(50) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comprobantes`
--

INSERT INTO `comprobantes` (`id`, `tipo_comprobante`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'FACTURA', 1, '2026-02-13 12:53:47', '2026-02-13 12:53:47'),
(2, 'BOLETA', 2, '2026-02-13 13:02:54', '2026-02-13 13:02:54'),
(3, 'NOTA DE CREDITO', 3, '2026-02-13 13:03:21', '2026-02-13 13:03:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisas`
--

CREATE TABLE `divisas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `nombre_completo` varchar(191) NOT NULL,
  `simbolo` varchar(3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `divisas`
--

INSERT INTO `divisas` (`id`, `codigo`, `nombre_completo`, `simbolo`, `created_at`, `updated_at`) VALUES
(1, 'COP', 'Peso Colombiano', '$', '2026-02-24 00:30:10', '2026-02-24 00:30:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_documento` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id`, `tipo_documento`, `created_at`, `updated_at`) VALUES
(1, 'CC', NULL, NULL),
(2, 'Pasaporte', NULL, NULL),
(3, 'NIT', NULL, NULL),
(4, 'CE', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `razon_social` varchar(191) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `img_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(191) NOT NULL,
  `ruc` varchar(50) NOT NULL,
  `propietario` varchar(191) NOT NULL,
  `telefono` varchar(191) DEFAULT NULL,
  `correo` varchar(191) DEFAULT NULL,
  `direccion` varchar(191) NOT NULL,
  `ubicacion` varchar(191) DEFAULT NULL,
  `abreviatura_impuesto` varchar(191) NOT NULL DEFAULT 'IVA',
  `porventaje_impuesto` decimal(5,2) NOT NULL DEFAULT 19.00,
  `divisa_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `ruc`, `propietario`, `telefono`, `correo`, `direccion`, `ubicacion`, `abreviatura_impuesto`, `porventaje_impuesto`, `divisa_id`, `created_at`, `updated_at`) VALUES
(1, 'AMGLOW S.A.S', '900123456-7', 'AAAAA', '3001234567', 'contacto@amglow.com', 'Calle 123 #45-67', 'Bogotá, Colombia', 'IVA', 19.00, 1, '2026-02-24 00:30:16', '2026-02-24 00:30:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `ubicacione_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` bigint(20) UNSIGNED NOT NULL,
  `cantidad_minima` bigint(20) UNSIGNED DEFAULT NULL,
  `cantidad_maxima` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_transacion` enum('COMPRA','AJUSTE','APERTURA') NOT NULL,
  `descripcion_transaccion` varchar(191) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `saldo` int(11) NOT NULL,
  `costo_unitario` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `caracteristica_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `caracteristica_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-02-10 00:12:15', '2026-02-10 00:12:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_29_234401_create_documentos_table', 1),
(6, '2024_03_29_235201_create_personas_table', 1),
(7, '2024_03_30_000309_create_proveedores_table', 1),
(8, '2024_03_30_001540_create_clientes_table', 1),
(9, '2024_03_30_005059_create_comprobantes_table', 1),
(10, '2024_03_30_005552_create_compras_table', 1),
(11, '2024_03_30_013232_create_ventas_table', 1),
(12, '2024_03_30_014859_create_caracteristicas_table', 1),
(13, '2024_03_30_020218_create_categorias_table', 1),
(14, '2024_03_30_035856_create_marcas_table', 1),
(15, '2024_03_30_040558_create_productos_table', 1),
(16, '2024_03_30_043401_create_categoria_producto_table', 1),
(17, '2024_03_30_044138_create_compra_producto_table', 1),
(18, '2024_03_30_045010_create_producto_venta_table', 1),
(19, '2025_01_22_045205_create_marcas_table', 1),
(20, '2025_02_08_190152_update_colums_to_documentos_table', 1),
(21, '2025_02_08_190913_update_colums_to_personas_table', 1),
(22, '2025_03_16_015605_rename_numero_comprobante_column', 1),
(23, '2025_03_27_231344_create_permission_tables', 1),
(24, '2025_07_12_151118_create_divisas_table', 1),
(25, '2025_07_12_161428_create_empresas_table', 1),
(26, '2025_07_12_180345_create_empleados_table', 1),
(27, '2025_07_12_183311_update_columns_to_users_table', 1),
(28, '2026_01_11_121212_create_cajas_table', 1),
(29, '2026_01_11_193139_create_movimientos_table', 1),
(30, '2026_01_11_195655_update_columns_to_ventas_table', 1),
(31, '2026_01_12_225107_create_kardexes_table', 1),
(32, '2026_01_18_194446_create_ubicaciones_table', 1),
(33, '2026_01_18_194629_create_inventario_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('VENTA','RETIRO') NOT NULL,
  `descripcion` varchar(191) NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `metodo_pago` enum('EFECTIVO','TARJETA') NOT NULL,
  `caja_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ver-categoria', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(2, 'crear-categoria', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(3, 'editar-categoria', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(4, 'eliminar-categoria', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(5, 'ver-cliente', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(6, 'crear-cliente', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(7, 'editar-cliente', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(8, 'eliminar-cliente', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(9, 'ver-compra', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(10, 'crear-compra', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(11, 'mostrar-compra', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(12, 'eliminar-compra', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(13, 'ver-marca', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(14, 'crear-marca', 'web', '2026-02-08 04:10:47', '2026-02-08 04:10:47'),
(15, 'editar-marca', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(16, 'eliminar-marca', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(17, 'ver-presentacione', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(18, 'crear-presentacione', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(19, 'editar-presentacione', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(20, 'eliminar-presentacione', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(21, 'ver-producto', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(22, 'crear-producto', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(23, 'editar-producto', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(24, 'eliminar-producto', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(25, 'ver-proveedore', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(26, 'crear-proveedore', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(27, 'editar-proveedore', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(28, 'eliminar-proveedore', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(29, 'ver-venta', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(30, 'crear-venta', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(31, 'mostrar-venta', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48'),
(32, 'eliminar-venta', 'web', '2026-02-08 04:10:48', '2026-02-08 04:10:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `razon_social` varchar(80) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `documento_id` bigint(20) UNSIGNED NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `razon_social`, `direccion`, `tipo_persona`, `estado`, `documento_id`, `numero_documento`, `created_at`, `updated_at`) VALUES
(1, 'Comercializadora Global S.A.S. arb', 'Calle 158 #45-67, Bogotá, Colombia', 'JURIDICA', 1, 1, '92929292299292', '2026-02-13 04:32:34', '2026-02-22 21:13:26'),
(2, 'Abril Indusries S.A.S.', 'Calle 158 #92a-37, Bogotá, Colombia', 'JURIDICA', 1, 1, '1014658714', '2026-02-13 04:36:01', '2026-02-22 21:13:45'),
(3, 'Andres Abril', 'calle128a #92a10', 'natural', 1, 1, '1234567890', '2026-02-16 00:24:27', '2026-02-16 00:24:27'),
(4, 'NIVEA COMPANY S.A.S', 'calle127 #20-30', 'juridica', 1, 3, '1234567890212', '2026-02-16 00:32:26', '2026-02-16 00:32:26'),
(5, 'Juan Martinez', 'calle92 #10-23', 'natural', 1, 1, '1011010100011', '2026-02-20 17:47:24', '2026-02-20 17:47:24'),
(6, 'Sara Ruiz', 'calle 127 #20-24', 'natural', 1, 1, '99999999999999', '2026-02-20 17:48:32', '2026-02-20 17:48:32'),
(7, 'Camilo Almiral', 'calle23 #10-10', 'natural', 1, 1, '65656565656', '2026-02-22 21:12:52', '2026-02-22 21:12:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `marca_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `stock`, `descripcion`, `fecha_vencimiento`, `img_path`, `estado`, `marca_id`, `created_at`, `updated_at`) VALUES
(1, '0502', 'Toallas Limpiadoras 500', 1027, 'Toallas para limpieza del cuerpo', '2030-02-28', NULL, 1, 1, '2026-02-24 00:45:55', '2026-02-24 00:45:55'),
(5, '01', 'ACEITE DE MANOS', 231, 'aceite muy rico', '2027-12-11', NULL, 1, 1, '2026-02-10 01:16:07', '2026-02-22 22:38:40'),
(6, '02', 'A.B.C', 5012, 'acndnoad', '2026-10-21', NULL, 1, 1, '2026-02-10 15:13:20', '2026-02-10 15:13:20'),
(7, '03', 'Aceite para el cuerpo y manos', 9, 'ajcjajajajajaja', '2030-11-11', NULL, 1, 1, '2026-02-13 04:27:00', '2026-02-15 23:58:33'),
(8, 'PRD343', 'Jabón Facial Nivea 500ml', 45, 'Producto para el cuidado de pieles grasas', '2028-07-12', NULL, 1, 1, '2026-02-15 23:58:27', '2026-02-15 23:58:27'),
(9, 'PDR434', 'Jabon en barra', 44, 'producto xxxx', '2027-11-11', NULL, 1, 1, '2026-02-16 00:02:24', '2026-02-16 00:02:24'),
(10, '23412341324', 'adsfasdfasdfasf', 0, 'adsfasdfas', '2044-02-19', NULL, 1, 1, '2026-02-20 01:29:24', '2026-02-20 01:29:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_venta`
--

CREATE TABLE `producto_venta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `venta_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `descuento` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_venta`
--

INSERT INTO `producto_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_venta`, `descuento`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 12, 6800.00, 0.00, '2026-01-13 13:43:35', '2026-01-13 13:43:35'),
(2, 2, 7, 12, 6800.00, 0.00, '2026-02-13 13:47:51', '2026-02-13 13:47:51'),
(3, 3, 5, 30, 5000.00, 0.00, '2026-02-17 17:18:57', '2026-02-17 17:18:57'),
(4, 4, 5, 5, 5000.00, 0.00, '2026-02-19 15:58:33', '2026-02-19 15:58:33'),
(5, 5, 5, 2, 4.00, 0.00, '2026-02-22 21:28:48', '2026-02-22 21:28:48'),
(6, 6, 5, 2, 4.00, 0.00, '2026-02-22 21:35:34', '2026-02-22 21:35:34'),
(7, 7, 5, 2, 4.00, 0.00, '2026-02-22 21:36:38', '2026-02-22 21:36:38'),
(8, 8, 5, 2, 4.00, 0.00, '2026-02-22 22:04:22', '2026-02-22 22:04:22'),
(9, 9, 5, 21, 4.00, 0.00, '2026-02-22 22:38:40', '2026-02-22 22:38:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `persona_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `persona_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-02-13 04:36:25', '2026-02-13 04:36:25'),
(2, 4, '2026-02-16 00:32:26', '2026-02-16 00:32:26'),
(3, 5, '2026-02-20 17:47:24', '2026-02-20 17:47:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'web', '2026-02-08 04:00:41', '2026-02-08 05:08:29'),
(2, 'Vendedor', 'web', '2026-02-22 22:02:52', '2026-02-22 22:02:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `empleado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `empleado_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$jNIaWD0AeTB63flI0H2O2OkMlNCFSzmi.KoDxSya/R7yzxdIMFd86', NULL, NULL, 1, '2026-02-08 02:44:44', '2026-02-08 02:44:44'),
(2, 'Juan Contreras', 'juan@gmail.com', NULL, '$2y$10$bf250g8I49jQ47/0s.V7m.DkmuKAn0eEprWG2RmIkWh6GfTvruvz2', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(8,2) NOT NULL,
  `numero_comprobante` varchar(255) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `cliente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `caja_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comprobante_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha_hora`, `impuesto`, `numero_comprobante`, `total`, `estado`, `cliente_id`, `user_id`, `caja_id`, `comprobante_id`, `created_at`, `updated_at`) VALUES
(1, '2026-01-13 08:43:35', 15504.00, '6', 97104.00, 1, 1, 2, 1, 2, '2026-01-13 13:43:35', '2026-01-13 13:43:35'),
(2, '2026-02-13 08:47:36', 15504.00, '7', 97104.00, 1, 1, 2, 1, 1, '2026-02-13 13:47:51', '2026-02-13 13:47:51'),
(3, '2026-02-17 12:18:31', 28500.00, '34444a', 178500.00, 0, 2, 2, 1, 1, '2026-02-17 17:18:57', '2026-02-17 17:21:25'),
(4, '2026-02-19 10:57:06', 4750.00, '7777777', 29750.00, 1, 2, 2, 1, 1, '2026-02-19 15:58:32', '2026-02-19 15:58:32'),
(5, '2026-02-22 16:28:37', 2000.00, '123123123', 10000.00, 1, 1, 1, 1, 1, '2026-02-22 21:28:48', '2026-02-22 21:28:48'),
(6, '2026-02-22 16:35:26', 2000.00, '123123123123123', 10000.00, 1, 1, 1, 1, 2, '2026-02-22 21:35:34', '2026-02-22 21:35:34'),
(7, '2026-02-22 16:36:28', 2000.00, '7676', 10000.00, 1, 2, 1, 1, 1, '2026-02-22 21:36:38', '2026-02-22 21:36:38'),
(8, '2026-02-22 17:04:07', 2000.00, 'asdfa123123', 10000.00, 1, 1, 1, 1, 2, '2026-02-22 22:04:22', '2026-02-22 22:04:22'),
(9, '2026-02-22 17:38:29', 16000.00, 'ggggggggggggg', 100000.00, 1, 2, 2, 1, 1, '2026-02-22 22:38:40', '2026-02-22 22:38:40');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cajas_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_caracteristica_id_unique` (`caracteristica_id`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_producto_producto_id_foreign` (`producto_id`),
  ADD KEY `categoria_producto_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_persona_id_unique` (`persona_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_comprobante_id_foreign` (`comprobante_id`),
  ADD KEY `compras_proveedore_id_foreign` (`proveedore_id`);

--
-- Indices de la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_producto_compra_id_foreign` (`compra_id`),
  ADD KEY `compra_producto_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `divisas`
--
ALTER TABLE `divisas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_divisa_id_foreign` (`divisa_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventario_producto_id_unique` (`producto_id`),
  ADD KEY `inventario_ubicacione_id_foreign` (`ubicacione_id`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kardex_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marcas_caracteristica_id_unique` (`caracteristica_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_caja_id_foreign` (`caja_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personas_documento_id_foreign` (`documento_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_marca_id_foreign` (`marca_id`);

--
-- Indices de la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_venta_venta_id_foreign` (`venta_id`),
  ADD KEY `producto_venta_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proveedores_persona_id_unique` (`persona_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_empleado_id_unique` (`empleado_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `ventas_user_id_foreign` (`user_id`),
  ADD KEY `ventas_comprobante_id_foreign` (`comprobante_id`),
  ADD KEY `ventas_caja_id_foreign` (`caja_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `comprobantes`
--
ALTER TABLE `comprobantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `divisas`
--
ALTER TABLE `divisas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD CONSTRAINT `cajas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_caracteristica_id_foreign` FOREIGN KEY (`caracteristica_id`) REFERENCES `caracteristicas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD CONSTRAINT `categoria_producto_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categoria_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_comprobante_id_foreign` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `compras_proveedore_id_foreign` FOREIGN KEY (`proveedore_id`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  ADD CONSTRAINT `compra_producto_compra_id_foreign` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_divisa_id_foreign` FOREIGN KEY (`divisa_id`) REFERENCES `divisas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventario_ubicacione_id_foreign` FOREIGN KEY (`ubicacione_id`) REFERENCES `ubicaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD CONSTRAINT `kardex_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD CONSTRAINT `marcas_caracteristica_id_foreign` FOREIGN KEY (`caracteristica_id`) REFERENCES `caracteristicas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personas`
--
ALTER TABLE `personas`
  ADD CONSTRAINT `personas_documento_id_foreign` FOREIGN KEY (`documento_id`) REFERENCES `documentos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_marca_id_foreign` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_venta`
--
ALTER TABLE `producto_venta`
  ADD CONSTRAINT `producto_venta_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_venta_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_persona_id_foreign` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_empleado_id_foreign` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `cajas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ventas_comprobante_id_foreign` FOREIGN KEY (`comprobante_id`) REFERENCES `comprobantes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
