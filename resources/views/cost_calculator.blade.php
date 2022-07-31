<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cost Calculator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .container {
            margin-top: 80px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center">Project Cost Calculator</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <form action="{{ url('cost-calculation-pdf') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row" id="costInputSection">
                                        <div class="col-md-6">
                                            <label for="frontend_dev">Frontend Developer:</label>
                                            <input type="number" class="form-control" id="frontend_dev" name="frontend_dev">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="frontend_dev_cost">Cost/Salary per dev:</label>
                                            <input type="number" class="form-control" id="frontend_dev_cost" name="frontend_dev_cost">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="backend_dev">Backend Developer:</label>
                                            <input type="number" class="form-control" id="backend_dev" name="backend_dev">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="backend_dev_cost">Cost/Salary per dev:</label>
                                            <input type="number" class="form-control" id="backend_dev_cost" name="backend_dev_cost">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mobile_app_dev">Mobile app Developer:</label>
                                            <input type="number" class="form-control" id="mobile_app_dev" name="mobile_app_dev">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mobile_app_dev_cost">Cost/Salary per dev:</label>
                                            <input type="number" class="form-control" id="mobile_app_dev_cost" name="mobile_app_dev_cost">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="total_hour">Number of hours to do work:</label>
                                            <input type="number" class="form-control" id="total_hour" name="total_hour">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cost_per_hour">Cost per hour:</label>
                                            <input type="number" class="form-control" id="cost_per_hour" name="cost_per_hour">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="server_cost">Server Cost:</label>
                                            <input type="number" class="form-control" id="server_cost" name="server_cost">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="domain_cost">Domain Cost:</label>
                                            <input type="number" class="form-control" id="domain_cost" name="domain_cost">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="vat">Vat/Tex:</label>
                                            <input type="number" class="form-control" id="vat" name="vat">
                                        </div>

                                    </div>
                                </div><br><br><br>
                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label for="company_logo">Logo of company:</label>
                                            <input type="file" class="form-control" id="company_logo" name="image">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="company_address">Address of company:</label>
                                            <input type="text" class="form-control" id="company_address" name="company_address">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="client_name">Name of client:</label>
                                            <input type="text" class="form-control" id="client_name" name="client_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="client_address">Address of client:</label>
                                            <input type="text" class="form-control" id="client_address" name="client_address">
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-info pull-right" id="addMoreItem">Add more item</button>
                                <button type="submit" class="btn btn-success">Calculate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {

            let costInputSection = document.getElementById("costInputSection");
            let addMoreItem = document.getElementById("addMoreItem");

            var itemNumber = 0;
            addMoreItem.addEventListener("click", function(e) {
                event.preventDefault();

                itemNumber++;

                var div1 = createDivElement()
                var div2 = createDivElement()

                var input1 = createInputField(itemNumber, "text")
                var input2 = createInputField(itemNumber, "number")

                var fieldName = createLabel('Field Name')
                var fieldValue = createLabel('Field Value')

                appendChildintoParent(div1, fieldName)
                appendChildintoParent(div2, fieldValue)

                appendChildintoParent(div1, input1)
                appendChildintoParent(div2, input2)

                costInputSection.appendChild(div1)
                costInputSection.appendChild(div2)
            })

            function createDivElement() {
                let div = document.createElement("div")
                div.classList.add("col-md-6")
                return div;
            }

            function createInputField(itemNumber, type) {
                let input = document.createElement("input")
                input.setAttribute("type", `${type}`)
                input.classList.add("form-control")
                input.setAttribute("name", `items${itemNumber}[]`)
                return input;
            }

            function createLabel(fieldname) {
                var labelName = `${fieldname}`
                let label = document.createElement("label")
                label.innerHTML = labelName;
                return label;
            }

            function appendChildintoParent(parent, children) {
                parent.appendChild(children)
            }
        });
    </script>
</body>

</html>