

            function testDecimals(currentVal) {
                            var count;
                            currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
                            return count;
            }

            function replaceCommas(yourNumber) {
                var components = yourNumber.toString().split(".");
                if (components.length === 1) 
                    components[0] = yourNumber;
                components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                if (components.length === 2)
                    components[1] = components[1].replace(/\D/g, "");
                return components.join(".");
            }

            function number_format(currentVal){
                            var testDecimal = testDecimals(currentVal);
                                      if (testDecimal.length > 1) {
                                          currentVal = currentVal.slice(0, -1);                      
                                      }

                                      return replaceCommas(currentVal); 
            }
