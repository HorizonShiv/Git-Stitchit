(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === 'object' && typeof module === 'object')
    module.exports = factory();
  else if (typeof define === 'function' && define.amd)
    define([], factory);
  else {
    var a = factory();
    for (var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
  }
})(self, function () {
  return /******/ (function () { // webpackBootstrap
    /******/
    var __webpack_modules__ = ({

      /***/ "./resources/assets/vendor/libs/formvalidation/dist/js/locales/es_ES.js":
      /*!******************************************************************************!*\
        !*** ./resources/assets/vendor/libs/formvalidation/dist/js/locales/es_ES.js ***!
        \******************************************************************************/
      /***/ (function (module, exports, __webpack_require__) {

        var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;

        function _typeof(o) {
          "@babel/helpers - typeof";
          return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
            return typeof o;
          } : function (o) {
            return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
          }, _typeof(o);
        }

        (function (global, factory) {
          (false ? 0 : _typeof(exports)) === 'object' && "object" !== 'undefined' ? module.exports = factory() : true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
            __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
              (__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
              __WEBPACK_AMD_DEFINE_FACTORY__),
          __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : (0);
        })(this, function () {
          'use strict';

          /**
           * Spanish language package
           * Translated by @vadail
           */
          var es_ES = {
            base64: {
              "default": 'Por favor introduce un valor válido en base 64'
            },
            between: {
              "default": 'Por favor introduce un valor entre %s y %s',
              notInclusive: 'Por favor introduce un valor sólo entre %s and %s'
            },
            bic: {
              "default": 'Por favor introduce un número BIC válido'
            },
            callback: {
              "default": 'Por favor introduce un valor válido'
            },
            choice: {
              between: 'Por favor elija de %s a %s opciones',
              "default": 'Por favor introduce un valor válido',
              less: 'Por favor elija %s opciones como mínimo',
              more: 'Por favor elija %s optiones como máximo'
            },
            color: {
              "default": 'Por favor introduce un color válido'
            },
            creditCard: {
              "default": 'Por favor introduce un número válido de tarjeta de crédito'
            },
            cusip: {
              "default": 'Por favor introduce un número CUSIP válido'
            },
            date: {
              "default": 'Por favor introduce una fecha válida',
              max: 'Por favor introduce una fecha previa al %s',
              min: 'Por favor introduce una fecha posterior al %s',
              range: 'Por favor introduce una fecha entre el %s y el %s'
            },
            different: {
              "default": 'Por favor introduce un valor distinto'
            },
            digits: {
              "default": 'Por favor introduce sólo dígitos'
            },
            ean: {
              "default": 'Por favor introduce un número EAN válido'
            },
            ein: {
              "default": 'Por favor introduce un número EIN válido'
            },
            emailAddress: {
              "default": 'Por favor introduce un email válido'
            },
            file: {
              "default": 'Por favor elija un archivo válido'
            },
            greaterThan: {
              "default": 'Por favor introduce un valor mayor o igual a %s',
              notInclusive: 'Por favor introduce un valor mayor que %s'
            },
            grid: {
              "default": 'Por favor introduce un número GRId válido'
            },
            hex: {
              "default": 'Por favor introduce un valor hexadecimal válido'
            },
            iban: {
              countries: {
                AD: 'Andorra',
                AE: 'Emiratos Árabes Unidos',
                AL: 'Albania',
                AO: 'Angola',
                AT: 'Austria',
                AZ: 'Azerbaiyán',
                BA: 'Bosnia-Herzegovina',
                BE: 'Bélgica',
                BF: 'Burkina Faso',
                BG: 'Bulgaria',
                BH: 'Baréin',
                BI: 'Burundi',
                BJ: 'Benín',
                BR: 'Brasil',
                CH: 'Suiza',
                CI: 'Costa de Marfil',
                CM: 'Camerún',
                CR: 'Costa Rica',
                CV: 'Cabo Verde',
                CY: 'Cyprus',
                CZ: 'República Checa',
                DE: 'Alemania',
                DK: 'Dinamarca',
                DO: 'República Dominicana',
                DZ: 'Argelia',
                EE: 'Estonia',
                ES: 'España',
                FI: 'Finlandia',
                FO: 'Islas Feroe',
                FR: 'Francia',
                GB: 'Reino Unido',
                GE: 'Georgia',
                GI: 'Gibraltar',
                GL: 'Groenlandia',
                GR: 'Grecia',
                GT: 'Guatemala',
                HR: 'Croacia',
                HU: 'Hungría',
                IE: 'Irlanda',
                IL: 'Israel',
                IR: 'Iran',
                IS: 'Islandia',
                IT: 'Italia',
                JO: 'Jordania',
                KW: 'Kuwait',
                KZ: 'Kazajistán',
                LB: 'Líbano',
                LI: 'Liechtenstein',
                LT: 'Lituania',
                LU: 'Luxemburgo',
                LV: 'Letonia',
                MC: 'Mónaco',
                MD: 'Moldavia',
                ME: 'Montenegro',
                MG: 'Madagascar',
                MK: 'Macedonia',
                ML: 'Malí',
                MR: 'Mauritania',
                MT: 'Malta',
                MU: 'Mauricio',
                MZ: 'Mozambique',
                NL: 'Países Bajos',
                NO: 'Noruega',
                PK: 'Pakistán',
                PL: 'Poland',
                PS: 'Palestina',
                PT: 'Portugal',
                QA: 'Catar',
                RO: 'Rumania',
                RS: 'Serbia',
                SA: 'Arabia Saudita',
                SE: 'Suecia',
                SI: 'Eslovenia',
                SK: 'Eslovaquia',
                SM: 'San Marino',
                SN: 'Senegal',
                TL: 'Timor Oriental',
                TN: 'Túnez',
                TR: 'Turquía',
                VG: 'Islas Vírgenes Británicas',
                XK: 'República de Kosovo'
              },
              country: 'Por favor introduce un número IBAN válido en %s',
              "default": 'Por favor introduce un número IBAN válido'
            },
            id: {
              countries: {
                BA: 'Bosnia Herzegovina',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CH: 'Suiza',
                CL: 'Chile',
                CN: 'China',
                CZ: 'República Checa',
                DK: 'Dinamarca',
                EE: 'Estonia',
                ES: 'España',
                FI: 'Finlandia',
                HR: 'Croacia',
                IE: 'Irlanda',
                IS: 'Islandia',
                LT: 'Lituania',
                LV: 'Letonia',
                ME: 'Montenegro',
                MK: 'Macedonia',
                NL: 'Países Bajos',
                PL: 'Poland',
                RO: 'Romania',
                RS: 'Serbia',
                SE: 'Suecia',
                SI: 'Eslovenia',
                SK: 'Eslovaquia',
                SM: 'San Marino',
                TH: 'Tailandia',
                TR: 'Turquía',
                ZA: 'Sudáfrica'
              },
              country: 'Por favor introduce un número válido de identificación en %s',
              "default": 'Por favor introduce un número de identificación válido'
            },
            identical: {
              "default": 'Por favor introduce el mismo valor'
            },
            imei: {
              "default": 'Por favor introduce un número IMEI válido'
            },
            imo: {
              "default": 'Por favor introduce un número IMO válido'
            },
            integer: {
              "default": 'Por favor introduce un número válido'
            },
            ip: {
              "default": 'Por favor introduce una dirección IP válida',
              ipv4: 'Por favor introduce una dirección IPv4 válida',
              ipv6: 'Por favor introduce una dirección IPv6 válida'
            },
            isbn: {
              "default": 'Por favor introduce un número ISBN válido'
            },
            isin: {
              "default": 'Por favor introduce un número ISIN válido'
            },
            ismn: {
              "default": 'Por favor introduce un número ISMN válido'
            },
            issn: {
              "default": 'Por favor introduce un número ISSN válido'
            },
            lessThan: {
              "default": 'Por favor introduce un valor menor o igual a %s',
              notInclusive: 'Por favor introduce un valor menor que %s'
            },
            mac: {
              "default": 'Por favor introduce una dirección MAC válida'
            },
            meid: {
              "default": 'Por favor introduce un número MEID válido'
            },
            notEmpty: {
              "default": 'Por favor introduce un valor'
            },
            numeric: {
              "default": 'Por favor introduce un número decimal válido'
            },
            phone: {
              countries: {
                AE: 'Emiratos Árabes Unidos',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CN: 'China',
                CZ: 'República Checa',
                DE: 'Alemania',
                DK: 'Dinamarca',
                ES: 'España',
                FR: 'Francia',
                GB: 'Reino Unido',
                IN: 'India',
                MA: 'Marruecos',
                NL: 'Países Bajos',
                PK: 'Pakistán',
                RO: 'Rumania',
                RU: 'Rusa',
                SK: 'Eslovaquia',
                TH: 'Tailandia',
                US: 'Estados Unidos',
                VE: 'Venezuela'
              },
              country: 'Por favor introduce un número válido de teléfono en %s',
              "default": 'Por favor introduce un número válido de teléfono'
            },
            promise: {
              "default": 'Por favor introduce un valor válido'
            },
            regexp: {
              "default": 'Por favor introduce un valor que coincida con el patrón'
            },
            remote: {
              "default": 'Por favor introduce un valor válido'
            },
            rtn: {
              "default": 'Por favor introduce un número RTN válido'
            },
            sedol: {
              "default": 'Por favor introduce un número SEDOL válido'
            },
            siren: {
              "default": 'Por favor introduce un número SIREN válido'
            },
            siret: {
              "default": 'Por favor introduce un número SIRET válido'
            },
            step: {
              "default": 'Por favor introduce un paso válido de %s'
            },
            stringCase: {
              "default": 'Por favor introduce sólo caracteres en minúscula',
              upper: 'Por favor introduce sólo caracteres en mayúscula'
            },
            stringLength: {
              between: 'Por favor introduce un valor con una longitud entre %s y %s caracteres',
              "default": 'Por favor introduce un valor con una longitud válida',
              less: 'Por favor introduce menos de %s caracteres',
              more: 'Por favor introduce más de %s caracteres'
            },
            uri: {
              "default": 'Por favor introduce una URI válida'
            },
            uuid: {
              "default": 'Por favor introduce un número UUID válido',
              version: 'Por favor introduce una versión UUID válida para %s'
            },
            vat: {
              countries: {
                AT: 'Austria',
                BE: 'Bélgica',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CH: 'Suiza',
                CY: 'Chipre',
                CZ: 'República Checa',
                DE: 'Alemania',
                DK: 'Dinamarca',
                EE: 'Estonia',
                EL: 'Grecia',
                ES: 'España',
                FI: 'Finlandia',
                FR: 'Francia',
                GB: 'Reino Unido',
                GR: 'Grecia',
                HR: 'Croacia',
                HU: 'Hungría',
                IE: 'Irlanda',
                IS: 'Islandia',
                IT: 'Italia',
                LT: 'Lituania',
                LU: 'Luxemburgo',
                LV: 'Letonia',
                MT: 'Malta',
                NL: 'Países Bajos',
                NO: 'Noruega',
                PL: 'Polonia',
                PT: 'Portugal',
                RO: 'Rumanía',
                RS: 'Serbia',
                RU: 'Rusa',
                SE: 'Suecia',
                SI: 'Eslovenia',
                SK: 'Eslovaquia',
                VE: 'Venezuela',
                ZA: 'Sudáfrica'
              },
              country: 'Por favor introduce un número IVA válido en %s',
              "default": 'Por favor introduce un número IVA válido'
            },
            vin: {
              "default": 'Por favor introduce un número VIN válido'
            },
            zipCode: {
              countries: {
                AT: 'Austria',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CA: 'Canadá',
                CH: 'Suiza',
                CZ: 'República Checa',
                DE: 'Alemania',
                DK: 'Dinamarca',
                ES: 'España',
                FR: 'Francia',
                GB: 'Reino Unido',
                IE: 'Irlanda',
                IN: 'India',
                IT: 'Italia',
                MA: 'Marruecos',
                NL: 'Países Bajos',
                PL: 'Poland',
                PT: 'Portugal',
                RO: 'Rumanía',
                RU: 'Rusa',
                SE: 'Suecia',
                SG: 'Singapur',
                SK: 'Eslovaquia',
                US: 'Estados Unidos'
              },
              country: 'Por favor introduce un código postal válido en %s',
              "default": 'Por favor introduce un código postal válido'
            }
          };
          return es_ES;
        });

        /***/
      })

      /******/
    });
    /************************************************************************/
    /******/ 	// The module cache
    /******/
    var __webpack_module_cache__ = {};
    /******/
    /******/ 	// The require function
    /******/
    function __webpack_require__(moduleId) {
      /******/ 		// Check if module is in cache
      /******/
      var cachedModule = __webpack_module_cache__[moduleId];
      /******/
      if (cachedModule !== undefined) {
        /******/
        return cachedModule.exports;
        /******/
      }
      /******/ 		// Create a new module (and put it into the cache)
      /******/
      var module = __webpack_module_cache__[moduleId] = {
        /******/ 			// no module.id needed
        /******/ 			// no module.loaded needed
        /******/      exports: {}
        /******/
      };
      /******/
      /******/ 		// Execute the module function
      /******/
      __webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
      /******/
      /******/ 		// Return the exports of the module
      /******/
      return module.exports;
      /******/
    }

    /******/
    /************************************************************************/
    /******/
    /******/ 	// startup
    /******/ 	// Load entry module and return exports
    /******/ 	// This entry module is referenced by other modules so it can't be inlined
    /******/
    var __webpack_exports__ = __webpack_require__("./resources/assets/vendor/libs/formvalidation/dist/js/locales/es_ES.js");
    /******/
    /******/
    return __webpack_exports__;
    /******/
  })()
    ;
});
