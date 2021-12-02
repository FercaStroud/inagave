import { Component, Prop, Mixins } from 'vue-property-decorator';
import { Line, mixins } from 'vue-chartjs';

@Component({
  extends: Line, // this is important to add the functionality to your component
  mixins: [mixins.reactiveProp],
})

export default class LineChart extends Mixins(mixins.reactiveProp, Line) {
  @Prop() chartData: any;
  @Prop() options: any;

  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart(this.chartData, this.options);
  }
}
