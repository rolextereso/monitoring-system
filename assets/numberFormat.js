

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
