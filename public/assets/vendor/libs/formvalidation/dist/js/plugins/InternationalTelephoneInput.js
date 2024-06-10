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

      /***/ "./resources/assets/vendor/libs/formvalidation/dist/js/plugins/InternationalTelephoneInput.js":
      /*!****************************************************************************************************!*\
        !*** ./resources/assets/vendor/libs/formvalidation/dist/js/plugins/InternationalTelephoneInput.js ***!
        \****************************************************************************************************/
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

        /**
         * FormValidation (https://formvalidation.io), v1.10.0 (2236098)
         * The best validation library for JavaScript
         * (c) 2013 - 2021 Nguyen Huu Phuoc <me@phuoc.ng>
         */

        (function (global, factory) {
          (false ? 0 : _typeof(exports)) === 'object' && "object" !== 'undefined' ? module.exports = factory() : true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
            __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
              (__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
              __WEBPACK_AMD_DEFINE_FACTORY__),
          __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : (0);
        })(this, function () {
          'use strict';

          function _classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError("Cannot call a class as a function");
            }
          }

          function _defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ("value" in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps) _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, "prototype", {
              writable: false
            });
            return Constructor;
          }

          function _defineProperty(obj, key, value) {
            if (key in obj) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true
              });
            } else {
              obj[key] = value;
            }
            return obj;
          }

          function _inherits(subClass, superClass) {
            if (typeof superClass !== "function" && superClass !== null) {
              throw new TypeError("Super expression must either be null or a function");
            }
            subClass.prototype = Object.create(superClass && superClass.prototype, {
              constructor: {
                value: subClass,
                writable: true,
                configurable: true
              }
            });
            Object.defineProperty(subClass, "prototype", {
              writable: false
            });
            if (superClass) _setPrototypeOf(subClass, superClass);
          }

          function _getPrototypeOf(o) {
            _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
              return o.__proto__ || Object.getPrototypeOf(o);
            };
            return _getPrototypeOf(o);
          }

          function _setPrototypeOf(o, p) {
            _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
              o.__proto__ = p;
              return o;
            };
            return _setPrototypeOf(o, p);
          }

          function _isNativeReflectConstruct() {
            if (typeof Reflect === "undefined" || !Reflect.construct) return false;
            if (Reflect.construct.sham) return false;
            if (typeof Proxy === "function") return true;
            try {
              Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {
              }));
              return true;
            } catch (e) {
              return false;
            }
          }

          function _assertThisInitialized(self) {
            if (self === void 0) {
              throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            }
            return self;
          }

          function _possibleConstructorReturn(self, call) {
            if (call && (_typeof(call) === "object" || typeof call === "function")) {
              return call;
            } else if (call !== void 0) {
              throw new TypeError("Derived constructors may only return object or undefined");
            }
            return _assertThisInitialized(self);
          }

          function _createSuper(Derived) {
            var hasNativeReflectConstruct = _isNativeReflectConstruct();
            return function _createSuperInternal() {
              var Super = _getPrototypeOf(Derived),
                result;
              if (hasNativeReflectConstruct) {
                var NewTarget = _getPrototypeOf(this).constructor;
                result = Reflect.construct(Super, arguments, NewTarget);
              } else {
                result = Super.apply(this, arguments);
              }
              return _possibleConstructorReturn(this, result);
            };
          }

          var t = FormValidation.Plugin;
          var e = /*#__PURE__*/function (_t) {
            _inherits(e, _t);
            var _super = _createSuper(e);

            function e(t) {
              var _this;
              _classCallCheck(this, e);
              _this = _super.call(this, t);
              _this.intlTelInstances = new Map();
              _this.countryChangeHandler = new Map();
              _this.fieldElements = new Map();
              _this.opts = Object.assign({}, {
                autoPlaceholder: "polite",
                utilsScript: ""
              }, t);
              _this.validatePhoneNumber = _this.checkPhoneNumber.bind(_assertThisInitialized(_this));
              _this.fields = typeof _this.opts.field === "string" ? _this.opts.field.split(",") : _this.opts.field;
              return _this;
            }

            _createClass(e, [{
              key: "install",
              value: function install() {
                var _this2 = this;
                this.core.registerValidator(e.INT_TEL_VALIDATOR, this.validatePhoneNumber);
                this.fields.forEach(function (t) {
                  _this2.core.addField(t, {
                    validators: _defineProperty({}, e.INT_TEL_VALIDATOR, {
                      message: _this2.opts.message
                    })
                  });
                  var s = _this2.core.getElements(t)[0];
                  var i = function i() {
                    return _this2.core.revalidateField(t);
                  };
                  s.addEventListener("countrychange", i);
                  _this2.countryChangeHandler.set(t, i);
                  _this2.fieldElements.set(t, s);
                  _this2.intlTelInstances.set(t, intlTelInput(s, _this2.opts));
                });
              }
            }, {
              key: "uninstall",
              value: function uninstall() {
                var _this3 = this;
                this.fields.forEach(function (t) {
                  var s = _this3.countryChangeHandler.get(t);
                  var i = _this3.fieldElements.get(t);
                  var n = _this3.getIntTelInstance(t);
                  if (s && i && n) {
                    i.removeEventListener("countrychange", s);
                    _this3.core.disableValidator(t, e.INT_TEL_VALIDATOR);
                    n.destroy();
                  }
                });
              }
            }, {
              key: "getIntTelInstance",
              value: function getIntTelInstance(t) {
                return this.intlTelInstances.get(t);
              }
            }, {
              key: "checkPhoneNumber",
              value: function checkPhoneNumber() {
                var _this4 = this;
                return {
                  validate: function validate(t) {
                    var _e = t.value;
                    var s = _this4.getIntTelInstance(t.field);
                    if (_e === "" || !s) {
                      return {
                        valid: true
                      };
                    }
                    return {
                      valid: s.isValidNumber()
                    };
                  }
                };
              }
            }]);
            return e;
          }(t);
          e.INT_TEL_VALIDATOR = "___InternationalTelephoneInputValidator";
          return e;
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
    var __webpack_exports__ = __webpack_require__("./resources/assets/vendor/libs/formvalidation/dist/js/plugins/InternationalTelephoneInput.js");
    /******/
    /******/
    return __webpack_exports__;
    /******/
  })()
    ;
});
