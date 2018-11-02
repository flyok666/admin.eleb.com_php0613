@extends('admin.layout.default')


@section('contents')
    <script src="/js/echarts.common.min.js"></script>
<h1>最近一周订单量统计</h1>
<table class="table table-bordered table-responsive">
    <tr>
        @foreach($result as $date=>$total)
        <th>{{ $date }}</th>
        @endforeach
    </tr>
    <tr>
        @foreach($result as $date=>$total)
            <td>{{ $total }}</td>
        @endforeach
    </tr>
</table>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 600px;height:400px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '一周订单数量统计'
            },
            tooltip: {},
            legend: {
                data:['订单量']
            },
            xAxis: {
                data: @php echo json_encode(array_keys($result)) @endphp
            },
            yAxis: {},
            series: [{
                name: '销量',
                type: 'line',
                data: @php echo json_encode(array_values($result)) @endphp
            }]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@stop