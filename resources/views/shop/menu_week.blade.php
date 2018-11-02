@extends('admin.layout.default')


@section('contents')
    <script src="/js/echarts.common.min.js"></script>
<h1>最近一周菜品销量统计</h1>
<table class="table table-bordered table-responsive">
    <tr>
        <th>菜品名称</th>
        @foreach($week as $day)
        <th>{{ $day }}</th>
        @endforeach
    </tr>

        @foreach($result as $id=>$data)
        <tr>
            <td>{{ $menus[$id] }}</td>
            @foreach($data as $total)
            <td>{{ $total }}</td>
             @endforeach
        </tr>
        @endforeach



</table>
    <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" style="width: 600px;height:400px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: ''
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:@php echo json_encode(array_values($menus)) @endphp
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: @php echo json_encode($week) @endphp
            },
            yAxis: {
                type: 'value'
            },
            series: @php echo json_encode($series) @endphp
        };


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>
@stop