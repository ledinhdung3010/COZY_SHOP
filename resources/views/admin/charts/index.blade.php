@extends('admin_layout')
@section('title','STATISTICAL')
@section('breadcrumb-item-1','By product quantity')
@section('breadcrumb-item-2','STATISTICAL')

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h5 class="text-center">PRODUCTS QUANTITY</h5>
        
        <div class="alert alert-danger" id="errorMessage" style="display: none;">
      
        </div>
        
        <form action="{{route('admin.charts.get')}}" class="border p-3" method="post">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">Từ ngày</label>
                        <input type="datetime-local" class="form-control" name="date1" value="" step="1">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">Đến ngày</label>
                        <input type="datetime-local" class="form-control" name="date2" value="" step="1">
                    </div> 
                </div>
                <div class="col-sm-12 col-md-12">
                  <input type="text" list="productList" placeholder="Nhập ten san pham" name="productName" class="form-control">
                  <datalist id="productList">
                    @foreach ($products as $item)
                    <option id="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                  </datalist>
                    
                </div>
                <div class="col-sm-12 col-md-12 mt-4">
                    <button  id="charts" type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </div>
            
            
        </form>
        <div class="card-body">
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
      
    </div>
</div>
@endsection
@push('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#charts").click(function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form
            const ctx = document.getElementById('myChart');
            var currentChart = Chart.getChart(ctx);
        // Nếu tồn tại biểu đồ hiện tại, hãy xóa nó trước khi tạo biểu đồ mới
        if (currentChart) {
            currentChart.destroy();
        }
        var errorMessage = document.getElementById('errorMessage');
            var date1Value = $("input[name='date1']").val();
            var date2Value = $("input[name='date2']").val();
            var productName = $("input[name='productName']").val();
            var csrfToken = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('admin.charts.get') }}",
                type: "POST",
                data: {"date1": date1Value, "date2":date2Value,"product":productName,'_token':csrfToken},
                success: function(result) {
                  if(result.cod==401){
                   
                    errorMessage.style.display = 'block';
                    errorMessage.innerHTML = result.error; // Thêm văn bản lỗi vào phần tử div
                     // Hiển thị phần tử div chứa thông báo lỗi
                    event.preventDefault(); // Ngăn chặn việc gửi form
                  }else{
                    errorMessage.style.display = 'none';
                    var labels = [];
                    var data = [];

                    // Xây dựng mảng labels và data từ result.products
                    result.products.forEach(function(item) {
                        labels.push(item.name);
                        data.push(item.total_quantity);
                    });
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                          labels:labels,
                          datasets: [{
                            label: 'Product quantity',
                            data:data,
                            borderWidth: 1
                          }]
                        },
                        options: {
                          scales: {
                            y: {
                              beginAtZero: true
                            }
                          }
                        }
                      });
                  }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                              });
                          });
                      });
</script>

@endpush
