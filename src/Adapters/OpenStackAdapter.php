<?php

// Put this adapter to its own package so not everybody is forced to install all the
// OpenStack PHP packages!

// This is a wrapper for the Remote adapter. Before the job is pushed, this adapter
// checks if an OpenStack compute instance is running with the GPU server. It tracks the
// IPs of the currently active GPU server(s) using the cache. If none is running, it
// boots one up using a configured image that automatically starts the GPU server. It
// polls the compute instance until the GPU server responds (with an "idle-since"
// endpoint?). Then it submits the job using the Remote adapter.
//
// This adapter also regularly polls any active GPU servers. If one is idle for a
// configured time span, the compute instance is destroyed.
//
// All this implies that the adapter can manage one or more compute instances. The
// number can be configured. If more than one instance is available, jobs are submitted
// round-robin.
