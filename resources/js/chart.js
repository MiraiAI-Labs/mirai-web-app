import { Chart } from 'chart.js/auto';
import { WordCloudController, WordElement } from 'chartjs-chart-wordcloud';

Chart.register(WordCloudController, WordElement);
window.Chart = Chart;
window.WordCloudController = WordCloudController;