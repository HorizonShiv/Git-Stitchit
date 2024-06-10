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

      /***/ "./resources/assets/vendor/libs/formvalidation/dist/js/locales/no_NO.js":
      /*!******************************************************************************!*\
        !*** ./resources/assets/vendor/libs/formvalidation/dist/js/locales/no_NO.js ***!
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
           * Norwegian language package
           * Translated by @trondulseth
           */
          var no_NO = {
            base64: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig base64-kodet verdi'
            },
            between: {
              "default": 'Vennligst fyll ut dette feltet med en verdi mellom %s og %s',
              notInclusive: 'Vennligst tast inn kun en verdi mellom %s og %s'
            },
            bic: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig BIC-nummer'
            },
            callback: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig verdi'
            },
            choice: {
              between: 'Vennligst velg %s - %s valgmuligheter',
              "default": 'Vennligst fyll ut dette feltet med en gyldig verdi',
              less: 'Vennligst velg minst %s valgmuligheter',
              more: 'Vennligst velg maks %s valgmuligheter'
            },
            color: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig'
            },
            creditCard: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig kreditkortnummer'
            },
            cusip: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig CUSIP-nummer'
            },
            date: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig dato',
              max: 'Vennligst fyll ut dette feltet med en gyldig dato før %s',
              min: 'Vennligst fyll ut dette feltet med en gyldig dato etter %s',
              range: 'Vennligst fyll ut dette feltet med en gyldig dato mellom %s - %s'
            },
            different: {
              "default": 'Vennligst fyll ut dette feltet med en annen verdi'
            },
            digits: {
              "default": 'Vennligst tast inn kun sifre'
            },
            ean: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig EAN-nummer'
            },
            ein: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig EIN-nummer'
            },
            emailAddress: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig epostadresse'
            },
            file: {
              "default": 'Velg vennligst en gyldig fil'
            },
            greaterThan: {
              "default": 'Vennligst fyll ut dette feltet med en verdi større eller lik %s',
              notInclusive: 'Vennligst fyll ut dette feltet med en verdi større enn %s'
            },
            grid: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig GRIDnummer'
            },
            hex: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig hexadecimalt nummer'
            },
            iban: {
              countries: {
                AD: 'Andorra',
                AE: 'De Forente Arabiske Emirater',
                AL: 'Albania',
                AO: 'Angola',
                AT: 'Østerrike',
                AZ: 'Aserbajdsjan',
                BA: 'Bosnia-Hercegovina',
                BE: 'Belgia',
                BF: 'Burkina Faso',
                BG: 'Bulgaria',
                BH: 'Bahrain',
                BI: 'Burundi',
                BJ: 'Benin',
                BR: 'Brasil',
                CH: 'Sveits',
                CI: 'Elfenbenskysten',
                CM: 'Kamerun',
                CR: 'Costa Rica',
                CV: 'Kapp Verde',
                CY: 'Kypros',
                CZ: 'Tsjekkia',
                DE: 'Tyskland',
                DK: 'Danmark',
                DO: 'Den dominikanske republikk',
                DZ: 'Algerie',
                EE: 'Estland',
                ES: 'Spania',
                FI: 'Finland',
                FO: 'Færøyene',
                FR: 'Frankrike',
                GB: 'Storbritannia',
                GE: 'Georgia',
                GI: 'Gibraltar',
                GL: 'Grønland',
                GR: 'Hellas',
                GT: 'Guatemala',
                HR: 'Kroatia',
                HU: 'Ungarn',
                IE: 'Irland',
                IL: 'Israel',
                IR: 'Iran',
                IS: 'Island',
                IT: 'Italia',
                JO: 'Jordan',
                KW: 'Kuwait',
                KZ: 'Kasakhstan',
                LB: 'Libanon',
                LI: 'Liechtenstein',
                LT: 'Litauen',
                LU: 'Luxembourg',
                LV: 'Latvia',
                MC: 'Monaco',
                MD: 'Moldova',
                ME: 'Montenegro',
                MG: 'Madagaskar',
                MK: 'Makedonia',
                ML: 'Mali',
                MR: 'Mauritania',
                MT: 'Malta',
                MU: 'Mauritius',
                MZ: 'Mosambik',
                NL: 'Nederland',
                NO: 'Norge',
                PK: 'Pakistan',
                PL: 'Polen',
                PS: 'Palestina',
                PT: 'Portugal',
                QA: 'Qatar',
                RO: 'Romania',
                RS: 'Serbia',
                SA: 'Saudi-Arabia',
                SE: 'Sverige',
                SI: 'Slovenia',
                SK: 'Slovakia',
                SM: 'San Marino',
                SN: 'Senegal',
                TL: 'øst-Timor',
                TN: 'Tunisia',
                TR: 'Tyrkia',
                VG: 'De Britiske Jomfruøyene',
                XK: 'Republikken Kosovo'
              },
              country: 'Vennligst fyll ut dette feltet med et gyldig IBAN-nummer i %s',
              "default": 'Vennligst fyll ut dette feltet med et gyldig IBAN-nummer'
            },
            id: {
              countries: {
                BA: 'Bosnien-Hercegovina',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CH: 'Sveits',
                CL: 'Chile',
                CN: 'Kina',
                CZ: 'Tsjekkia',
                DK: 'Danmark',
                EE: 'Estland',
                ES: 'Spania',
                FI: 'Finland',
                HR: 'Kroatia',
                IE: 'Irland',
                IS: 'Island',
                LT: 'Litauen',
                LV: 'Latvia',
                ME: 'Montenegro',
                MK: 'Makedonia',
                NL: 'Nederland',
                PL: 'Polen',
                RO: 'Romania',
                RS: 'Serbia',
                SE: 'Sverige',
                SI: 'Slovenia',
                SK: 'Slovakia',
                SM: 'San Marino',
                TH: 'Thailand',
                TR: 'Tyrkia',
                ZA: 'Sør-Afrika'
              },
              country: 'Vennligst fyll ut dette feltet med et gyldig identifikasjons-nummer i %s',
              "default": 'Vennligst fyll ut dette feltet med et gyldig identifikasjons-nummer'
            },
            identical: {
              "default": 'Vennligst fyll ut dette feltet med den samme verdi'
            },
            imei: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig IMEI-nummer'
            },
            imo: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig IMO-nummer'
            },
            integer: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig tall'
            },
            ip: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig IP adresse',
              ipv4: 'Vennligst fyll ut dette feltet med en gyldig IPv4 adresse',
              ipv6: 'Vennligst fyll ut dette feltet med en gyldig IPv6 adresse'
            },
            isbn: {
              "default": 'Vennligst fyll ut dette feltet med ett gyldig ISBN-nummer'
            },
            isin: {
              "default": 'Vennligst fyll ut dette feltet med ett gyldig ISIN-nummer'
            },
            ismn: {
              "default": 'Vennligst fyll ut dette feltet med ett gyldig ISMN-nummer'
            },
            issn: {
              "default": 'Vennligst fyll ut dette feltet med ett gyldig ISSN-nummer'
            },
            lessThan: {
              "default": 'Vennligst fyll ut dette feltet med en verdi mindre eller lik %s',
              notInclusive: 'Vennligst fyll ut dette feltet med en verdi mindre enn %s'
            },
            mac: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig MAC adresse'
            },
            meid: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig MEID-nummer'
            },
            notEmpty: {
              "default": 'Vennligst fyll ut dette feltet'
            },
            numeric: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig flytende desimaltall'
            },
            phone: {
              countries: {
                AE: 'De Forente Arabiske Emirater',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CN: 'Kina',
                CZ: 'Tsjekkia',
                DE: 'Tyskland',
                DK: 'Danmark',
                ES: 'Spania',
                FR: 'Frankrike',
                GB: 'Storbritannia',
                IN: 'India',
                MA: 'Marokko',
                NL: 'Nederland',
                PK: 'Pakistan',
                RO: 'Rumenia',
                RU: 'Russland',
                SK: 'Slovakia',
                TH: 'Thailand',
                US: 'USA',
                VE: 'Venezuela'
              },
              country: 'Vennligst fyll ut dette feltet med et gyldig telefonnummer i %s',
              "default": 'Vennligst fyll ut dette feltet med et gyldig telefonnummer'
            },
            promise: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig verdi'
            },
            regexp: {
              "default": 'Vennligst fyll ut dette feltet med en verdi som matcher mønsteret'
            },
            remote: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig verdi'
            },
            rtn: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig RTN-nummer'
            },
            sedol: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig SEDOL-nummer'
            },
            siren: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig SIREN-nummer'
            },
            siret: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig SIRET-nummer'
            },
            step: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig trinn av %s'
            },
            stringCase: {
              "default": 'Venligst fyll inn dette feltet kun med små bokstaver',
              upper: 'Venligst fyll inn dette feltet kun med store bokstaver'
            },
            stringLength: {
              between: 'Vennligst fyll ut dette feltet med en verdi mellom %s og %s tegn',
              "default": 'Vennligst fyll ut dette feltet med en verdi av gyldig lengde',
              less: 'Vennligst fyll ut dette feltet med mindre enn %s tegn',
              more: 'Vennligst fyll ut dette feltet med mer enn %s tegn'
            },
            uri: {
              "default": 'Vennligst fyll ut dette feltet med en gyldig URI'
            },
            uuid: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig UUID-nummer',
              version: 'Vennligst fyll ut dette feltet med en gyldig UUID version %s-nummer'
            },
            vat: {
              countries: {
                AT: 'Østerrike',
                BE: 'Belgia',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CH: 'Schweiz',
                CY: 'Cypern',
                CZ: 'Tsjekkia',
                DE: 'Tyskland',
                DK: 'Danmark',
                EE: 'Estland',
                EL: 'Hellas',
                ES: 'Spania',
                FI: 'Finland',
                FR: 'Frankrike',
                GB: 'Storbritania',
                GR: 'Hellas',
                HR: 'Kroatia',
                HU: 'Ungarn',
                IE: 'Irland',
                IS: 'Island',
                IT: 'Italia',
                LT: 'Litauen',
                LU: 'Luxembourg',
                LV: 'Latvia',
                MT: 'Malta',
                NL: 'Nederland',
                NO: 'Norge',
                PL: 'Polen',
                PT: 'Portugal',
                RO: 'Romania',
                RS: 'Serbia',
                RU: 'Russland',
                SE: 'Sverige',
                SI: 'Slovenia',
                SK: 'Slovakia',
                VE: 'Venezuela',
                ZA: 'Sør-Afrika'
              },
              country: 'Vennligst fyll ut dette feltet med et gyldig MVA nummer i %s',
              "default": 'Vennligst fyll ut dette feltet med et gyldig MVA nummer'
            },
            vin: {
              "default": 'Vennligst fyll ut dette feltet med et gyldig VIN-nummer'
            },
            zipCode: {
              countries: {
                AT: 'Østerrike',
                BG: 'Bulgaria',
                BR: 'Brasil',
                CA: 'Canada',
                CH: 'Schweiz',
                CZ: 'Tsjekkia',
                DE: 'Tyskland',
                DK: 'Danmark',
                ES: 'Spania',
                FR: 'Frankrike',
                GB: 'Storbritannia',
                IE: 'Irland',
                IN: 'India',
                IT: 'Italia',
                MA: 'Marokko',
                NL: 'Nederland',
                PL: 'Polen',
                PT: 'Portugal',
                RO: 'Romania',
                RU: 'Russland',
                SE: 'Sverige',
                SG: 'Singapore',
                SK: 'Slovakia',
                US: 'USA'
              },
              country: 'Vennligst fyll ut dette feltet med et gyldig postnummer i %s',
              "default": 'Vennligst fyll ut dette feltet med et gyldig postnummer'
            }
          };
          return no_NO;
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
    var __webpack_exports__ = __webpack_require__("./resources/assets/vendor/libs/formvalidation/dist/js/locales/no_NO.js");
    /******/
    /******/
    return __webpack_exports__;
    /******/
  })()
    ;
});
