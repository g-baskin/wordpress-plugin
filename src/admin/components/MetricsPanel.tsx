/**
 * Metrics Panel Component
 */

import { useState, useEffect } from '@wordpress/element';
import { Icon, chartLine } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import './MetricsPanel.scss';

interface Metric {
	label: string;
	value: number | string;
	icon: string;
	color: string;
}

const MetricsPanel = () => {
	const [metrics, setMetrics] = useState<Metric[]>([]);
	const [loading, setLoading] = useState(true);

	useEffect(() => {
		const fetchMetrics = async () => {
			try {
				const response = await apiFetch({
					path: '/wordpress-app-test/v1/metrics',
				});

				if (response?.data) {
					setMetrics(response.data);
				}
			} catch (error) {
				console.error('Failed to fetch metrics:', error);
				// Set default metrics if fetch fails
				setMetrics([
					{ label: 'Total Posts', value: 0, icon: '📝', color: '#3b82f6' },
					{ label: 'Total Users', value: 0, icon: '👥', color: '#10b981' },
					{ label: 'Total Pages', value: 0, icon: '📄', color: '#f59e0b' },
					{ label: 'Total Comments', value: 0, icon: '💬', color: '#ef4444' },
				]);
			} finally {
				setLoading(false);
			}
		};

		fetchMetrics();
	}, []);

	if (loading) {
		return <div className="metrics-panel">Loading metrics...</div>;
	}

	return (
		<div className="metrics-panel">
			<div className="metrics-header">
				<h2>Site Metrics</h2>
				<p className="subtitle">Real-time WordPress site statistics</p>
			</div>

			<div className="metrics-grid">
				{metrics.map((metric, index) => (
					<div key={index} className="metric-card" style={{ borderLeftColor: metric.color }}>
						<div className="metric-icon">{metric.icon}</div>
						<div className="metric-content">
							<div className="metric-value">{metric.value}</div>
							<div className="metric-label">{metric.label}</div>
						</div>
					</div>
				))}
			</div>

			<div className="metrics-footer">
				<p className="last-updated">Last updated: {new Date().toLocaleTimeString()}</p>
			</div>
		</div>
	);
};

export default MetricsPanel;
