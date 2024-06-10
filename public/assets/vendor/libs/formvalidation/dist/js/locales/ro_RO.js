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

      /***/ "./resources/assets/vendor/libs/formvalidation/dist/js/locales/ro_RO.js":
      /*!******************************************************************************!*\
        !*** ./resources/assets/vendor/libs/formvalidation/dist/js/locales/ro_RO.js ***!
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
           * Romanian language package
           * Translated by @filipac
           */
          var ro_RO = {
            base64: {
              "default": 'Te rog introdu un base64 valid'
            },
            between: {
              "default": 'Te rog introdu o valoare intre %s si %s',
              notInclusive: 'Te rog introdu o valoare doar intre %s si %s'
            },
            bic: {
              "default": 'Te rog sa introduci un numar BIC valid'
            },
            callback: {
              "default": 'Te rog introdu o valoare valida'
            },
            choice: {
              between: 'Te rog alege %s - %s optiuni',
              "default": 'Te rog introdu o valoare valida',
              less: 'Te rog alege minim %s optiuni',
              more: 'Te rog alege maxim %s optiuni'
            },
            color: {
              "default": 'Te rog sa introduci o culoare valida'
            },
            creditCard: {
              "default": 'Te rog introdu un numar de card valid'
            },
            cusip: {
              "default": 'Te rog introdu un numar CUSIP valid'
            },
            date: {
              "default": 'Te rog introdu o data valida',
              max: 'Te rog sa introduci o data inainte de %s',
              min: 'Te rog sa introduci o data dupa %s',
              range: 'Te rog sa introduci o data in intervalul %s - %s'
            },
            different: {
              "default": 'Te rog sa introduci o valoare diferita'
            },
            digits: {
              "default": 'Te rog sa introduci doar cifre'
            },
            ean: {
              "default": 'Te rog sa introduci un numar EAN valid'
            },
            ein: {
              "default": 'Te rog sa introduci un numar EIN valid'
            },
            emailAddress: {
              "default": 'Te rog sa introduci o adresa de email valide'
            },
            file: {
              "default": 'Te rog sa introduci un fisier valid'
            },
            greaterThan: {
              "default": 'Te rog sa introduci o valoare mai mare sau egala cu %s',
              notInclusive: 'Te rog sa introduci  o valoare mai mare ca %s'
            },
            grid: {
              "default": 'Te rog sa introduci un numar GRId valid'
            },
            hex: {
              "default": 'Te rog sa introduci un numar hexadecimal valid'
            },
            iban: {
              countries: {
                AD: 'Andorra',
                AE: 'Emiratele Arabe unite',
                AL: 'Albania',
                AO: 'Angola',
                AT: 'Austria',
                AZ: 'Azerbaijan',
                BA: 'Bosnia si Herzegovina',
                BE: 'Belgia',
                BF: 'Burkina Faso',
                BG: 'Bulgaria',
                BH: 'Bahrain',
                BI: 'Burundi',
                BJ: 'Benin',
                BR: 'Brazilia',
                CH: 'Elvetia',
                CI: 'Coasta de Fildes',
                CM: 'Cameroon',
                CR: 'Costa Rica',
                CV: 'Cape Verde',
                CY: 'Cipru',
                CZ: 'Republica Cehia',
                DE: 'Germania',
                DK: 'Danemarca',
                DO: 'Republica Dominicană',
                DZ: 'Algeria',
                EE: 'Estonia',
                ES: 'Spania',
                FI: 'Finlanda',
                FO: 'Insulele Faroe',
                FR: 'Franta',
                GB: 'Regatul Unit',
                GE: 'Georgia',
                GI: 'Gibraltar',
                GL: 'Groenlanda',
                GR: 'Grecia',
                GT: 'Guatemala',
                HR: 'Croatia',
                HU: 'Ungaria',
                IE: 'Irlanda',
                IL: 'Israel',
                IR: 'Iran',
                IS: 'Islanda',
                IT: 'Italia',
                JO: 'Iordania',
                KW: 'Kuwait',
                KZ: 'Kazakhstan',
                LB: 'Lebanon',
                LI: 'Liechtenstein',
                LT: 'Lithuania',
                LU: 'Luxembourg',
                LV: 'Latvia',
                MC: 'Monaco',
                MD: 'Moldova',
                ME: 'Muntenegru',
                MG: 'Madagascar',
                MK: 'Macedonia',
                ML: 'Mali',
                MR: 'Mauritania',
                MT: 'Malta',
                MU: 'Mauritius',
                MZ: 'Mozambique',
                NL: 'Olanda',
                NO: 'Norvegia',
                PK: 'Pakistan',
                PL: 'Polanda',
                PS: 'Palestina',
                PT: 'Portugalia',
                QA: 'Qatar',
                RO: 'Romania',
                RS: 'Serbia',
                SA: 'Arabia Saudita',
                SE: 'Suedia',
                SI: 'Slovenia',
                SK: 'Slovacia',
                SM: 'San Marino',
                SN: 'Senegal',
                TL: 'Timorul de Est',
                TN: 'Tunisia',
                TR: 'Turkey',
                VG: 'Insulele Virgin',
                XK: 'Republica Kosovo'
              },
              country: 'Te rog sa introduci un IBAN valid din %s',
              "default": 'Te rog sa introduci un IBAN valid'
            },
            id: {
              countries: {
                BA: 'Bosnia si Herzegovina',
                BG: 'Bulgaria',
                BR: 'Brazilia',
                CH: 'Elvetia',
                CL: 'Chile',
                CN: 'China',
                CZ: 'Republica Cehia',
                DK: 'Danemarca',
                EE: 'Estonia',
                ES: 'Spania',
                FI: 'Finlanda',
                HR: 'Croatia',
                IE: 'Irlanda',
                IS: 'Islanda',
                LT: 'Lithuania',
                LV: 'Latvia',
                ME: 'Muntenegru',
                MK: 'Macedonia',
                NL: 'Olanda',
                PL: 'Polanda',
                RO: 'Romania',
                RS: 'Serbia',
                SE: 'Suedia',
                SI: 'Slovenia',
                SK: 'Slovacia',
                SM: 'San Marino',
                TH: 'Thailanda',
                TR: 'Turkey',
                ZA: 'Africa de Sud'
              },
              country: 'Te rog sa introduci un numar de identificare valid din %s',
              "default": 'Te rog sa introduci un numar de identificare valid'
            },
            identical: {
              "default": 'Te rog sa introduci aceeasi valoare'
            },
            imei: {
              "default": 'Te rog sa introduci un numar IMEI valid'
            },
            imo: {
              "default": 'Te rog sa introduci un numar IMO valid'
            },
            integer: {
              "default": 'Te rog sa introduci un numar valid'
            },
            ip: {
              "default": 'Te rog sa introduci o adresa IP valida',
              ipv4: 'Te rog sa introduci o adresa IPv4 valida',
              ipv6: 'Te rog sa introduci o adresa IPv6 valida'
            },
            isbn: {
              "default": 'Te rog sa introduci un numar ISBN valid'
            },
            isin: {
              "default": 'Te rog sa introduci un numar ISIN valid'
            },
            ismn: {
              "default": 'Te rog sa introduci un numar ISMN valid'
            },
            issn: {
              "default": 'Te rog sa introduci un numar ISSN valid'
            },
            lessThan: {
              "default": 'Te rog sa introduci o valoare mai mica sau egala cu %s',
              notInclusive: 'Te rog sa introduci o valoare mai mica decat %s'
            },
            mac: {
              "default": 'Te rog sa introduci o adresa MAC valida'
            },
            meid: {
              "default": 'Te rog sa introduci un numar MEID valid'
            },
            notEmpty: {
              "default": 'Te rog sa introduci o valoare'
            },
            numeric: {
              "default": 'Te rog sa introduci un numar'
            },
            phone: {
              countries: {
                AE: 'Emiratele Arabe unite',
                BG: 'Bulgaria',
                BR: 'Brazilia',
                CN: 'China',
                CZ: 'Republica Cehia',
                DE: 'Germania',
                DK: 'Danemarca',
                ES: 'Spania',
                FR: 'Franta',
                GB: 'Regatul Unit',
                IN: 'India',
                MA: 'Maroc',
                NL: 'Olanda',
                PK: 'Pakistan',
                RO: 'Romania',
                RU: 'Rusia',
                SK: 'Slovacia',
                TH: 'Thailanda',
                US: 'SUA',
                VE: 'Venezuela'
              },
              country: 'Te rog sa introduci un numar de telefon valid din %s',
              "default": 'Te rog sa introduci un numar de telefon valid'
            },
            promise: {
              "default": 'Te rog introdu o valoare valida'
            },
            regexp: {
              "default": 'Te rog sa introduci o valoare in formatul'
            },
            remote: {
              "default": 'Te rog sa introduci o valoare valida'
            },
            rtn: {
              "default": 'Te rog sa introduci un numar RTN valid'
            },
            sedol: {
              "default": 'Te rog sa introduci un numar SEDOL valid'
            },
            siren: {
              "default": 'Te rog sa introduci un numar SIREN valid'
            },
            siret: {
              "default": 'Te rog sa introduci un numar SIRET valid'
            },
            step: {
              "default": 'Te rog introdu un pas de %s'
            },
            stringCase: {
              "default": 'Te rog sa introduci doar litere mici',
              upper: 'Te rog sa introduci doar litere mari'
            },
            stringLength: {
              between: 'Te rog sa introduci o valoare cu lungimea intre %s si %s caractere',
              "default": 'Te rog sa introduci o valoare cu lungimea valida',
              less: 'Te rog sa introduci mai putin de %s caractere',
              more: 'Te rog sa introduci mai mult de %s caractere'
            },
            uri: {
              "default": 'Te rog sa introduci un URI valid'
            },
            uuid: {
              "default": 'Te rog sa introduci un numar UUID valid',
              version: 'Te rog sa introduci un numar UUID versiunea %s valid'
            },
            vat: {
              countries: {
                AT: 'Austria',
                BE: 'Belgia',
                BG: 'Bulgaria',
                BR: 'Brazilia',
                CH: 'Elvetia',
                CY: 'Cipru',
                CZ: 'Republica Cehia',
                DE: 'Germania',
                DK: 'Danemarca',
                EE: 'Estonia',
                EL: 'Grecia',
                ES: 'Spania',
                FI: 'Finlanda',
                FR: 'Franta',
                GB: 'Regatul Unit',
                GR: 'Grecia',
                HR: 'Croatia',
                HU: 'Ungaria',
                IE: 'Irlanda',
                IS: 'Islanda',
                IT: 'Italia',
                LT: 'Lituania',
                LU: 'Luxemburg',
                LV: 'Latvia',
                MT: 'Malta',
                NL: 'Olanda',
                NO: 'Norvegia',
                PL: 'Polanda',
                PT: 'Portugalia',
                RO: 'Romania',
                RS: 'Serbia',
                RU: 'Rusia',
                SE: 'Suedia',
                SI: 'Slovenia',
                SK: 'Slovacia',
                VE: 'Venezuela',
                ZA: 'Africa de Sud'
              },
              country: 'Te rog sa introduci un numar TVA valid din %s',
              "default": 'Te rog sa introduci un numar TVA valid'
            },
            vin: {
              "default": 'Te rog sa introduci un numar VIN valid'
            },
            zipCode: {
              countries: {
                AT: 'Austria',
                BG: 'Bulgaria',
                BR: 'Brazilia',
                CA: 'Canada',
                CH: 'Elvetia',
                CZ: 'Republica Cehia',
                DE: 'Germania',
                DK: 'Danemarca',
                ES: 'Spania',
                FR: 'Franta',
                GB: 'Regatul Unit',
                IE: 'Irlanda',
                IN: 'India',
                IT: 'Italia',
                MA: 'Maroc',
                NL: 'Olanda',
                PL: 'Polanda',
                PT: 'Portugalia',
                RO: 'Romania',
                RU: 'Rusia',
                SE: 'Suedia',
                SG: 'Singapore',
                SK: 'Slovacia',
                US: 'SUA'
              },
              country: 'Te rog sa introduci un cod postal valid din %s',
              "default": 'Te rog sa introduci un cod postal valid'
            }
          };
          return ro_RO;
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
    var __webpack_exports__ = __webpack_require__("./resources/assets/vendor/libs/formvalidation/dist/js/locales/ro_RO.js");
    /******/
    /******/
    return __webpack_exports__;
    /******/
  })()
    ;
});
